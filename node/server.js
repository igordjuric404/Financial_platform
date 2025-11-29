const WebSocket = require('ws');
const http = require('http');
const axios = require('axios');
const mysql = require('mysql2/promise');

// HTTP server for localhost only (Apache proxies to this)
const server = http.createServer();
const wss = new WebSocket.Server({ server });

// MySQL connection pool
const db = mysql.createPool({
    host: 'localhost',
    user: 'root',
    password: 'Tradingserbia123!',
    database: 'financial_platform_new',
    waitForConnections: true,
    connectionLimit: 10,
    queueLimit: 0
});

// TwelveData API configuration
const TWELVE_DATA_API_KEY = '58102220f146405c939ceec954eab48e';
const priceCache = {};

// Fetch prices from TwelveData API
async function fetchPrices() {
    const symbols = ['EUR/USD', 'GBP/USD', 'USD/JPY', 'AUD/USD', 'USD/CAD', 'AAPL', 'GOOGL', 'MSFT', 'AMZN', 'TSLA', 'XAU/USD', 'XAG/USD', 'WTI/USD', 'NG/USD'];
    
    try {
        const response = await axios.get('https://api.twelvedata.com/price', {
            params: { symbol: symbols.join(','), apikey: TWELVE_DATA_API_KEY }
        });

        if (response.data && typeof response.data === 'object') {
            Object.entries(response.data).forEach(([symbol, data]) => {
                if (data.price) priceCache[symbol] = parseFloat(data.price);
            });
            console.log('Prices updated:', Object.keys(priceCache).length);
        }
    } catch (error) {
        console.error('Error fetching prices:', error.message);
    }
}

// Check and close positions based on stop/limit
async function checkAndClosePosition(symbol, latestPrice) {
    try {
        const query = 'SELECT user_id, id as deal_id, stop_at, limit_at, size, opening FROM deals WHERE symbol = ? AND (stop_at IS NOT NULL OR limit_at IS NOT NULL)';
        const [deals] = await db.query(query, [symbol]);

        for (const deal of deals) {
            const shouldClose = (deal.stop_at > 0 && latestPrice <= deal.stop_at) || (deal.limit_at > 0 && latestPrice >= deal.limit_at);

            if (shouldClose) {
                console.log('Closing position', deal.deal_id, 'for user', deal.user_id);
                const formData = new URLSearchParams();
                formData.append('deal_id', deal.deal_id);
                formData.append('user_id', deal.user_id);

                try {
                    await axios.post('https://alpinecapitalmarkets.com/php/closePosition.php', formData, {
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
                    });
                    console.log('Position', deal.deal_id, 'closed successfully');
                } catch (error) {
                    console.error('Error closing position', deal.deal_id, ':', error.message);
                }
            }
        }
    } catch (error) {
        console.error('Error checking positions:', error.message);
    }
}

// Broadcast prices to all connected clients
function broadcast() {
    wss.clients.forEach(client => {
        if (client.readyState === WebSocket.OPEN) {
            client.send(JSON.stringify(priceCache));
        }
    });
}

// WebSocket connection handler
wss.on('connection', (ws) => {
    console.log('New WebSocket connection');
    ws.send(JSON.stringify(priceCache));
    ws.on('close', () => console.log('Client disconnected'));
});

// Main loop: fetch prices, broadcast, check positions
setInterval(async () => {
    await fetchPrices();
    broadcast();
    for (const [symbol, price] of Object.entries(priceCache)) {
        await checkAndClosePosition(symbol, price);
    }
}, 5000);

// Start server on localhost:8080
server.listen(8080, '127.0.0.1', () => {
    console.log('WebSocket server running on http://127.0.0.1:8080');
});

const WebSocket = require('ws');
const axios = require('axios'); 
const mysql = require('mysql2');
const http = require('http');

const apiKey = '58102220f146405c939ceec954eab48e';
const wsUrl = `wss://ws.twelvedata.com/v1/quotes/price?apikey=${apiKey}`;

// HTTP server for localhost only (Apache proxies to this)
const server = http.createServer();
const wss = new WebSocket.Server({ server });

const twelvedataWs = new WebSocket(wsUrl);

const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: 'Tradingserbia123!',
    database: 'financial_platform_new'
});

db.connect((err) => {
    if (err) {
        console.error('❌ [DATABASE] Connection failed:', err.stack);
        return;
    }
    console.log('✅ [DATABASE] Connected successfully (thread ID:', db.threadId + ')');
});

let lastPrices = {};

twelvedataWs.on('open', function open() {
    console.log('✅ [TWELVEDATA] Connected to TwelveData WebSocket server');

    const request = {
        action: 'subscribe',
        params: {
            symbols: 'BTC/USD,ETH/USD,SOL/USD,DOGE/USD,XRP/USD,ADA/USD,LTC/USD,XLM/USD,LINK/USD,EUR/USD,USD/JPY,GBP/USD,USD/CAD,USD/CHF,AUD/USD,NZD/USD,AAPL,GOOG,AMZN,MSFT,NVDA,META,TSLA,BRK.B,JPM,WMT,V,LLY,ORCL,MA,NFLX,XOM,JNJ,COST,HD,PLTR,ABBV,PG,BAC,CVX,KO,TMUS,GE,BABA,UNH,AMD,PM,CSCO,WFC,CRM,MS,ABT,CL1,CO1'
        }
    };

    twelvedataWs.send(JSON.stringify(request));
    console.log('📤 [TWELVEDATA] Subscription request sent for', Object.keys(request.params.symbols.split(',')).length, 'symbols');
});

let priceUpdateCount = 0;
let lastLogTime = Date.now();

twelvedataWs.on('message', function incoming(data) {
    try {
        const dataJson = JSON.parse(data);
        const symbol = dataJson.symbol;
        const latestPrice = parseFloat(dataJson.price);

        if (symbol && !isNaN(latestPrice)) {
            priceUpdateCount++;
            
            // Log every 10 price updates or every 30 seconds
            const now = Date.now();
            if (priceUpdateCount % 10 === 0 || (now - lastLogTime) > 30000) {
                console.log(`📊 [PRICE UPDATE] ${symbol}: $${latestPrice.toFixed(4)} (Total updates: ${priceUpdateCount})`);
                lastLogTime = now;
            }

            const prevPrice = lastPrices[symbol] || latestPrice;
            lastPrices[symbol] = latestPrice;

            checkAndClosePosition(symbol, latestPrice);
            checkAndExecuteOrders(symbol, prevPrice, latestPrice);

            // Broadcast to connected clients
            const connectedClients = Array.from(wss.clients).filter(c => c.readyState === WebSocket.OPEN).length;
            wss.clients.forEach(client => {
                if (client.readyState === WebSocket.OPEN) {
                    client.send(JSON.stringify({ symbol, price: latestPrice }));
                }
            });
            
            if (priceUpdateCount % 50 === 0) {
                console.log(`📡 [BROADCAST] Sent to ${connectedClients} connected client(s)`);
            }
        }

    } catch (error) {
        console.error("❌ [ERROR] Failed to parse TwelveData message:", error.message);
    }
});

function notifyClients(user_id, type, new_balance) {
    wss.clients.forEach(client => {
        if (client.readyState === WebSocket.OPEN) {
            client.send(JSON.stringify({
                action: 'update_table',
                type: type,
                user_id: user_id,
                new_balance: new_balance
            }));
        }
    });
}

// ====================== EXISTING DEALS LOGIC ======================
function checkAndClosePosition(symbol, latestPrice) {
    const query = `
        SELECT user_id, id as deal_id, stop_at, limit_at, size, opening 
        FROM deals 
        WHERE symbol = ? 
        AND (stop_at IS NOT NULL OR limit_at IS NOT NULL)
    `;

    db.query(query, [symbol], function(err, results) {
        if (err) {
            console.error('❌ [AUTO-CLOSE] Database error:', err.message);
            return;
        }

        if (results.length > 0) {
            console.log(`🔍 [AUTO-CLOSE] Checking ${results.length} deal(s) for ${symbol} at $${latestPrice.toFixed(4)}`);
        }

        results.forEach(deal => {
            const { user_id, deal_id, stop_at, limit_at, size, opening } = deal;

            const stopTriggered = stop_at > 0 && latestPrice <= stop_at;
            const limitTriggered = limit_at > 0 && latestPrice >= limit_at;

            if (stopTriggered) {
                console.log(`🛑 [STOP-LOSS] Triggered for deal ${deal_id} (user ${user_id}): price $${latestPrice.toFixed(4)} <= stop $${stop_at}`);
                closePosition(user_id, deal_id, size, symbol, opening, latestPrice);
            } else if (limitTriggered) {
                console.log(`🎯 [TAKE-PROFIT] Triggered for deal ${deal_id} (user ${user_id}): price $${latestPrice.toFixed(4)} >= limit $${limit_at}`);
                closePosition(user_id, deal_id, size, symbol, opening, latestPrice);
            }
        });
    });
}

function closePosition(user_id, deal_id, size, symbol, openingPrice, latestPrice) {
    console.log(`📤 [CLOSE] Sending close request for deal ${deal_id} (${symbol})`);
    
    const formData = new URLSearchParams();
    formData.append('user_id', user_id);
    formData.append('deal_id', deal_id);
    formData.append('size', size);
    formData.append('symbol', symbol);
    formData.append('openingPrice', openingPrice);
    formData.append('latestPrice', latestPrice);

    axios.post('https://alpinecapitalmarkets.com/php/closePosition.php', formData)
    .then(response => {
        console.log(`✅ [CLOSE] Deal ${deal_id} closed successfully:`, response.data);
        notifyClients(user_id, 'deal');
    })
    .catch(error => {
        console.error(`❌ [CLOSE] Failed to close deal ${deal_id}:`, error.message);
        if (error.response) {
            console.error(`   HTTP ${error.response.status}:`, error.response.data);
        }
    });
}

// ====================== NEW ORDERS LOGIC ======================
function checkAndExecuteOrders(symbol, prevPrice, latestPrice) {
    const query = `
        SELECT * 
        FROM orders
        WHERE symbol = ?
    `;

    db.query(query, [symbol], function(err, results) {
        if (err) {
            console.error('❌ [ORDERS] Database error:', err.message);
            return;
        }

        if (results.length > 0) {
            console.log(`🔍 [ORDERS] Checking ${results.length} pending order(s) for ${symbol}`);
        }

        results.forEach(order => {
            const { user_id, order_id, size, order_price, transaction_type, stop_at, limit_at } = order;

            if (order_price >= Math.min(prevPrice, latestPrice) && order_price <= Math.max(prevPrice, latestPrice)) {
                console.log(`⚡ [ORDER] Executing order ${order_id} (${transaction_type}) for ${symbol} at $${order_price}`);
                executeOrder(order);
            }
        });
    });
}

function executeOrder(order) {
    const { user_id, order_id, size, order_price, transaction_type, symbol, stop_at, limit_at } = order;

    const margin = Math.abs(size * order_price * 0.1);

    const formData = new URLSearchParams();
    formData.append('user_id', user_id);
    formData.append('size', size);
    formData.append('opening', order_price);
    formData.append('symbol', symbol);
    formData.append('margin', margin);
    formData.append('transaction_type', transaction_type);
    formData.append('stop_at', stop_at);
    formData.append('limit_at', limit_at);

    axios.post('https://alpinecapitalmarkets.com/php/processDeal.php', formData)
        .then(response => {
            console.log('Order izvršen i pretvoren u deal:', response.data);

            db.query('DELETE FROM orders WHERE order_id = ?', [order_id], (err) => {
                if (err) console.error('Greška pri brisanju ordera:', err);
                else console.log(`Order ${order_id} obrisan.`);

                notifyClients(user_id, 'order');
            });

        }).catch(err => console.error('Greška pri izvršavanju ordera:', err.message));
}

// ====================== WEBSOCKET SERVER ======================
wss.on('connection', function connection(ws) {
    const clientCount = wss.clients.size;
    console.log(`🔌 [CLIENT] New client connected (total: ${clientCount})`);

    // Send current cached prices immediately
    ws.send(JSON.stringify(lastPrices));
    console.log(`📤 [CLIENT] Sent ${Object.keys(lastPrices).length} cached prices to new client`);

    ws.on('message', function incoming(message) {
        console.log('📨 [CLIENT] Message received:', message.toString());
    });

    ws.on('close', function close() {
        console.log(`🔌 [CLIENT] Client disconnected (remaining: ${wss.clients.size})`);
    });

    ws.on('error', function error(err) {
        console.error('❌ [CLIENT] WebSocket error:', err.message);
    });
});

// Error handlers for TwelveData WebSocket
twelvedataWs.on('error', (error) => {
    console.error('❌ [TWELVEDATA] WebSocket error:', error.message);
});

twelvedataWs.on('close', () => {
    console.log('🔴 [TWELVEDATA] Connection closed. Attempting to reconnect...');
    // Note: In production, you should implement reconnection logic here
});

// Start server on localhost:8080
server.listen(8080, '127.0.0.1', () => {
    console.log('');
    console.log('='.repeat(60));
    console.log('🚀 WebSocket Server Started');
    console.log('='.repeat(60));
    console.log('   • Listening: http://127.0.0.1:8080');
    console.log('   • Public Path: wss://alpinecapitalmarkets.com/ws');
    console.log('   • Database: financial_platform_new');
    console.log('   • TwelveData: WebSocket subscription active');
    console.log('='.repeat(60));
    console.log('');
});

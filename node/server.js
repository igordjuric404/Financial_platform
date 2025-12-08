const WebSocket = require('ws');
const axios = require('axios'); 
const mysql = require('mysql2');

const apiKey = '58102220f146405c939ceec954eab48e';
const wsUrl = `wss://ws.twelvedata.com/v1/quotes/price?apikey=${apiKey}`;

const wss = new WebSocket.Server({ port: 8080 });
const twelvedataWs = new WebSocket(wsUrl);

const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '', 
    database: 'financial_platform_new'
});

db.connect((err) => {
    if (err) {
        console.error('Greška pri povezivanju sa bazom podataka: ', err.stack);
        return;
    }
    console.log('Povezan sa bazom podataka kao id ' + db.threadId);
});

let lastPrices = {};

twelvedataWs.on('open', function open() {
    console.log('Povezan sa WebSocket serverom TwelveData.');

    const request = {
        action: 'subscribe',
        params: {
            symbols: 'BTC/USD,ETH/USD,SOL/USD,DOGE/USD,XRP/USD,ADA/USD,LTC/USD,XLM/USD,LINK/USD,EUR/USD,USD/JPY,GBP/USD,USD/CAD,USD/CHF,AUD/USD,NZD/USD,AAPL,GOOG,AMZN,MSFT,NVDA,META,TSLA,BRK.B,JPM,WMT,V,LLY,ORCL,MA,NFLX,XOM,JNJ,COST,HD,PLTR,ABBV,PG,BAC,CVX,KO,TMUS,GE,BABA,UNH,AMD,PM,CSCO,WFC,CRM,MS,ABT,XAU/USD,XAG/USD,WTI/USD,XBR/USD,XPD/USD,XPT/USD,LMAHDS03,HG1,NG/USD,KC1,CC1,SB1,W_1,S_1'
        }
    };

    twelvedataWs.send(JSON.stringify(request));
    console.log('Poslat zahtev za simbole.');
});

twelvedataWs.on('message', function incoming(data) {
    try {
        const dataJson = JSON.parse(data);
        const symbol = dataJson.symbol;
        const latestPrice = parseFloat(dataJson.price);

        console.log(symbol + " cena je: " + latestPrice);

        if (symbol && !isNaN(latestPrice)) {

            const prevPrice = lastPrices[symbol] || latestPrice;
            lastPrices[symbol] = latestPrice;

            checkAndClosePosition(symbol, latestPrice);
            checkAndExecuteOrders(symbol, prevPrice, latestPrice);

            wss.clients.forEach(client => {
                if (client.readyState === WebSocket.OPEN) {
                    client.send(JSON.stringify({ symbol, price: latestPrice }));
                }
            });
        }

    } catch (error) {
        console.error("Greška pri parsiranju podataka:", error);
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
        SELECT user_id, deal_id, stop_at, limit_at, size, opening 
        FROM deals 
        WHERE symbol = ? 
        AND (stop_at IS NOT NULL OR limit_at IS NOT NULL)
    `;

    db.query(query, [symbol], function(err, results) {
        if (err) {
            console.error('Greška u bazi podataka:', err);
            return;
        }

        results.forEach(deal => {
            const { user_id, deal_id, stop_at, limit_at, size, opening } = deal;

            if ((stop_at > 0 && latestPrice <= stop_at) || (limit_at > 0 && latestPrice >= limit_at)) {
                closePosition(user_id, deal_id, size, symbol, opening, latestPrice);
            }
        });
    });
}

function closePosition(user_id, deal_id, size, symbol, openingPrice, latestPrice) {
    const formData = new URLSearchParams();
    formData.append('user_id', user_id);
    formData.append('deal_id', deal_id);
    formData.append('size', size);
    formData.append('symbol', symbol);
    formData.append('openingPrice', openingPrice);
    formData.append('latestPrice', latestPrice);

    axios.post('http://127.0.0.1/webapp/php/closePosition.php', formData)
    .then(response => {
        console.log('Pozicija zatvorena:', response.data);
        notifyClients(user_id, 'deal');
    })
    .catch(error => {
        console.error('Greska:', error);
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
        if (err) return console.error('Greška u bazi za orders:', err);

        results.forEach(order => {
            const { user_id, order_id, size, order_price, transaction_type, stop_at, limit_at } = order;

            if (order_price >= Math.min(prevPrice, latestPrice) && order_price <= Math.max(prevPrice, latestPrice)) {
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

    axios.post('http://127.0.0.1/webapp/php/processDeal.php', formData)
        .then(response => {
            console.log('Order izvršen i pretvoren u deal:', response.data);

            db.query('DELETE FROM orders WHERE order_id = ?', [order_id], (err) => {
                if (err) console.error('Greška pri brisanju ordera:', err);
                else console.log(`Order ${order_id} obrisan.`);

                notifyClients(user_id, 'order');
            });

        }).catch(err => console.error('Greška pri izvršavanju ordera:', err));
}

// ====================== WEBSOCKET SERVER ======================
wss.on('connection', function connection(ws) {
    console.log('Novi klijent povezan na ws://localhost:8080');

    ws.on('message', function incoming(message) {
        console.log('Primio poruku od klijenta:', message);
    });

    ws.on('close', function close() {
        console.log('Klijent je zatvorio vezu.');
    });

    ws.send(JSON.stringify({ message: 'Povezan sa ws://localhost:8080' }));
});

console.log('Lokalni WebSocket server je pokrenut na ws://localhost:8080');
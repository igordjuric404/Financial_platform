$(document).ready(function() {
    refreshUserBalance();
    let userBalance = parseFloat($('#user-balance').data('balance')) || 0;
    let deals = [];
    const spreadPercent = 0.001;

    // --------------------------------------------------
    //  WEBSOCKET
    // --------------------------------------------------
    const socket = new WebSocket('ws://localhost:8080');

    socket.onopen = function() { console.log('WebSocket connected'); };
    socket.onclose = function() { console.log('WebSocket disconnected'); };
    socket.onerror = function(err) { console.error('WebSocket error:', err); };

    socket.onmessage = function(event) {
        let data;

        if (typeof event.data === "string") {
            if (event.data.trim().startsWith('{') || event.data.trim().startsWith('[')) {
                try { data = JSON.parse(event.data); handleSocketData(data); }
                catch (e) { console.error("Greška pri parsiranju JSON-a:", e); }
            }
        } else if (event.data instanceof Blob) {
            const reader = new FileReader();
            reader.onload = function() {
                try { data = JSON.parse(reader.result); handleSocketData(data); }
                catch (e) { console.error("Greška pri parsiranju Blob-a:", e); }
            };
            reader.readAsText(event.data);
        }
    };

    function handleSocketData(data) {
        if(data.symbol && data.price) updateCryptoPrice(data.symbol, parseFloat(data.price));
    }

    function updateCryptoPrice(symbol, latestPrice) {
        const sellPrice = latestPrice * (1 - spreadPercent / 2);

        deals.forEach(deal => {
            if(deal.symbol === symbol) deal.latest = sellPrice;
        });

        calculateTotals();
    }

    // --------------------------------------------------
    //  UI & CALCULATIONS
    // --------------------------------------------------
    function formatCurrency(value) {
        return value.toLocaleString('en-US', { style: 'currency', currency: 'USD', minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function calculateTotals() {
        let totalPL = 0;
        let totalMargin = 0;

        const cryptoSymbols = ['BTC/USD','ETH/USD','SOL/USD','DOGE/USD','XRP/USD','ADA/USD','LTC/USD','XLM/USD','LINK/USD'];
        const forexSymbols = ['EUR/USD','USD/JPY','GBP/USD','USD/CAD','USD/CHF','AUD/USD','NZD/USD'];
        const stockSymbols = ['AAPL','GOOG','AMZN','MSFT','NVDA','META','TSLA','BRK.B','JPM','WMT','V','LLY','ORCL','MA','NFLX','XOM','JNJ','COST','HD','PLTR','ABBV','PG','BAC','CVX','KO','TMUS','GE','BABA','UNH','AMD','PM','CSCO','WFC','CRM','MS','ABT'];
        const commoditySymbols = ['XAU/USD','XAG/USD','WTI/USD','XBR/USD','XPD/USD','XPT/USD','LMAHDS03','HG1','NG/USD','KC1','CC1','SB1','W_1','S_1'];

        const forexSpecs = {
            "EUR/USD": { lotSize: 100000, quote: "USD" },
            "USD/JPY": { lotSize: 100000, quote: "JPY" },
            "GBP/USD": { lotSize: 100000, quote: "USD" },
            "AUD/USD": { lotSize: 100000, quote: "USD" },
            "NZD/USD": { lotSize: 100000, quote: "USD" },
            "USD/CAD": { lotSize: 100000, quote: "CAD" },
            "USD/CHF": { lotSize: 100000, quote: "CHF" }
        };

        const commodityLotSizes = {
            "WTI/USD": 1000,
            "XBR/USD": 1000,
            "XAU/USD": 100,
            "XAG/USD": 5000,
            "XPD/USD": 100,
            "XPT/USD": 100,
            "LMAHDS03": 25,
            "HG1": 25000,
            "NG/USD": 10000,
            "KC1": 37500,
            "CC1": 10,
            "SB1": 112000,
            "W_1": 5000,
            "S_1": 5000
        };

        deals.forEach(deal => {
            const size = parseFloat(deal.size) || 0;
            const opening = parseFloat(deal.opening) || 0;
            const latest = parseFloat(deal.latest) || opening;

            let profitLoss = 0;
            const symbol = deal.symbol;

            if (forexSpecs[symbol]) {
                const lotSize = forexSpecs[symbol].lotSize;
                let pl = (latest - opening) * lotSize * size;
                if (symbol.startsWith("USD/")) {
                    pl = pl / latest;
                }
                profitLoss = pl;

            } else if (commodityLotSizes[symbol]) {
                const lotSize = commodityLotSizes[symbol];
                profitLoss = (latest - opening) * lotSize * size;

            } else if (stockSymbols.includes(symbol)) {
                const lotSize = 100;
                profitLoss = (latest - opening) * lotSize * size;

            } else if (cryptoSymbols.includes(symbol)) {
                profitLoss = (latest - opening) * Math.abs(size) * 0.1;
            }

            totalPL += profitLoss;

            totalMargin += Math.abs(latest * size * 0.1);
        });

        $('#user-margin').text(formatCurrency(totalMargin));
        const available = (userBalance + totalPL) - totalMargin;
        $('#user-free').text(formatCurrency(available));
        $('#user-pl').text(formatCurrency(totalPL));
    }


    // --------------------------------------------------
    //  BALANCE REFRESH
    // --------------------------------------------------
    function refreshUserBalance() {
        $.ajax({
            url: 'php/getUserBalance.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const newBalance = parseFloat(response.balance);
                    const formattedBalance = newBalance.toLocaleString('en-US', { 
                        style: 'currency', currency: 'USD', minimumFractionDigits: 2, maximumFractionDigits: 2 
                    });

                    $('#user-balance').text(formattedBalance);
                    $('#user-balance').data('balance', newBalance);
                    $('#user-available').text(formattedBalance);
                } else {
                    console.error('Failed to refresh balance:', response.message);
                }
            },
            error: function(err) { console.error('AJAX error refreshing balance:', err); }
        });
    }

    // --------------------------------------------------
    //  LOAD DEALS
    // --------------------------------------------------
    function loadUserDeals() {
        $.ajax({
            url: 'php/getDeals.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    deals = response.deals;
                    calculateTotals();
                } else {
                    console.error('Failed to load deals:', response.message);
                }
            },
            error: function(err) { console.error('AJAX error loading deals:', err); }
        });
    }

    loadUserDeals();

    // --------------------------------------------------
    //  HISTORY CHART (Last 10 days) - P/L * 100 (%)
    // --------------------------------------------------
    let historyChart = null;

    function initHistoryChart() {
        const ctx = $("#historyChart")[0].getContext('2d');

        historyChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: "Daily P/L (%)",
                    data: [],
                    fill: true,
                    borderColor: "rgba(0,200,0,1)",
                    backgroundColor: "rgba(0,200,0,0.2)",
                    tension: 0.3, // za glatke linije
                    pointBackgroundColor: function(ctx) {
                        return ctx.raw >= 0 ? "green" : "red";
                    },
                    pointBorderColor: "#000",
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true },
                    title: {
                        display: true,
                        text: "Profit/Loss History (Last 10 Days)",
                        font: { size: 16 }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                return ctx.raw.toFixed(2) + "%";
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        ticks: { 
                            callback: v => v.toFixed(2) + "%",
                            color: "#000"
                        },
                        grid: {
                            color: function(context) {
                                return context.tick.value === 0 ? "#000" : "rgba(255,255,255,0.1)";
                            },
                            borderColor: "rgba(255,255,255,0.3)"
                        }
                    },
                    x: {
                        ticks: { color: "#ccc" },
                        grid: { display: false }
                    }
                }
            }
        });
    }

    function groupHistoryByDayPercent(deals, userBalance) {
        const map = {};

        deals.forEach(d => {
            const day = d.close_time.split(" ")[0];
            let pl = parseFloat(String(d.profit_loss).replace(/[$,]/g, '')) || 0;

            if (!map[day]) map[day] = 0;

            map[day] += (pl / userBalance) * 100;
        });

        const sorted = Object.entries(map).sort((a,b) => new Date(a[0]) - new Date(b[0]));
        const last10 = sorted.slice(-10);

        const emptySlots = 10 - last10.length;
        const labels = [];
        const values = [];

        for(let i = 0; i < emptySlots; i++) {
            labels.push("N/A");
            values.push(0);
        }

        last10.forEach(x => {
            labels.push(x[0]);
            values.push(x[1]);
        });

        return { labels, values };
    }



    function loadPLHistory() {
        $.ajax({
            url: 'php/getHistory.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    let userBalance = parseFloat($('#user-balance').data('balance')) || 1; // fallback 1
                    const grouped = groupHistoryByDayPercent(response.deals, userBalance);
                    updateHistoryChart(grouped.labels, grouped.values);
                } else {
                    console.warn(response.message);
                }
            },
            error: function(err) { console.error("Error loading history:", err); }
        });
    }

    function updateHistoryChart(labels, values) {
        historyChart.data.labels = labels;
        historyChart.data.datasets[0].data = values;
        historyChart.update();
    }

    initHistoryChart();
    loadPLHistory();
});
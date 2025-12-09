$(document).ready(function () {
    refreshUserBalance();
    updateDealsTable();
    
    // Dynamic WebSocket URL based on current protocol and hostname
    const wsProtocol = window.location.protocol === 'https:' ? 'wss:' : 'ws:';
    const wsHost = window.location.hostname;
    const wsPort = window.location.port ? `:${window.location.port}` : '';
    // Try /ws path first (for reverse proxy), fallback to port 8080 if needed
    const wsUrl = `${wsProtocol}//${wsHost}${wsPort}/ws`;
    
    console.log("🔌 Attempting WebSocket connection to:", wsUrl);
    
    function setupSocketHandlers(socket) {
        socket.onopen = function(event) {
            console.log("✅ WebSocket CONNECTED successfully!");
            console.log("📡 Sending subscribe request...");

            const request = {
                action: 'subscribe',
                params: {
                    symbols: 'BTC/USD,ETH/USD,LTC/USD,XRP/USD,SOL/USD,EUR/USD,USD/JPY,AAPL,GOOG,AMZN,GOLD,SILVER,OIL'
                }
            };
            socket.send(JSON.stringify(request));
            console.log("📤 Subscribe request sent:", request);
        };

        socket.onmessage = function(event) {
            console.log("📨 WebSocket message received:", event.data);
            let data;

            if (typeof event.data === "string") {
                if (event.data.trim().startsWith('{') || event.data.trim().startsWith('[')) {
                    try {
                        data = JSON.parse(event.data);
                        console.log("✅ Parsed WebSocket data:", data);
                        handleSocketData(data);
                    } catch (e) {
                        console.error("❌ Error parsing WebSocket data:", e);
                    }
                }
            } else if (event.data instanceof Blob) {
                const reader = new FileReader();
                reader.onload = function() {
                    try {
                        const blobData = reader.result;
                        data = JSON.parse(blobData);
                        handleSocketData(data);
                    } catch (e) {
                        console.error("❌ Error parsing Blob data:", e);
                    }
                };
                reader.readAsText(event.data);
            }
        };

        socket.onerror = function(error) {
            console.error("❌ WebSocket ERROR in handler:", error);
        };

        socket.onclose = function(event) {
            console.error("🔴 WebSocket CLOSED:", event.code, event.reason);
            if (event.code !== 1000) { // Not a normal closure
                console.log("⚠️ Unexpected WebSocket closure. Code:", event.code);
            }
        };
    }
    
    // Create socket and setup handlers
    let socket = new WebSocket(wsUrl);
    let fallbackAttempted = false;
    
    // Setup initial handlers
    setupSocketHandlers(socket);
    
    // Enhanced error handler with fallback (overrides the one in setupSocketHandlers)
    socket.onerror = function(error) {
        console.error("❌ WebSocket ERROR:", error);
        console.error("Failed to connect to:", wsUrl);
        // Try fallback to port 8080 if /ws fails (only once)
        if (!wsUrl.includes(':8080') && !fallbackAttempted) {
            fallbackAttempted = true;
            console.log("🔄 Attempting fallback connection to port 8080...");
            const fallbackUrl = `${wsProtocol}//${wsHost}:8080`;
            socket = new WebSocket(fallbackUrl);
            setupSocketHandlers(socket);
        }
    };
    
    let cryptoPrices = {}; 
    let currentPrice = 0; 
    let selectedCell = null;


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

    const commodityNames = {
        'XAU/USD': 'Gold',
        'XAG/USD': 'Silver',
        'WTI/USD': 'Crude Oil (WTI)',
        'XBR/USD': 'Crude Oil (Brent)',
        'XPD/USD': 'Palladium',
        'XPT/USD': 'Platinum',
        'LMAHDS03': 'Aluminum',
        'HG1': 'Copper',
        'NG/USD': 'Natural Gas',
        'KC1': 'Coffee',
        'CC1': 'Cocoa',
        'SB1': 'Sugar',
        'W_1': 'Wheat',
        'S_1': 'Soybeans'
    };

    function getReadableCommodity(symbol) {
        return commodityNames[symbol] || symbol;
    }

    function showPlaceDealError(message) {
        const errorDiv = $('#place-deal-error');
        errorDiv.text(message).fadeIn(200);

        setTimeout(() => {
            errorDiv.fadeOut(200);
        }, 5000);
    }

    function showPlaceDealErrorOrder(message) {
        const errorDiv = $('#place-deal-error-order');
        errorDiv.text(message).fadeIn(200);

        setTimeout(() => {
            errorDiv.fadeOut(200);
        }, 5000);
    }

    if (localStorage.getItem('positionsVisible') === 'true') {
        $('#positionsOverlay').show();
    } else {
        $('#positionsOverlay').hide();
    }

    localStorage.removeItem('positionsVisible');

    if (localStorage.getItem('cryptoChartVisible') === 'true') {
        $('#cryptoChartContainer').show();
    } else {
        $('#cryptoChartContainer').hide();
    }

    localStorage.removeItem('cryptoChartVisible');

    if (localStorage.getItem('ordersVisible') === 'true') {
        loadOrders();
        $('#ordersOverlay').show();
        $('#ordersTableContainer').show();

        
    } else {
        $('#ordersOverlay').hide();
        $('#ordersTableContainer').hide();
    }

    localStorage.removeItem('ordersVisible');

   $(".tab-deal").on("click", function () {
        $(".tab-deal").addClass("active-tab");
        $(".tab-order").removeClass("active-tab");

        $("#chart-deal").addClass("active-content");
        $("#chart-order").removeClass("active-content");
    });

    $(".tab-order").on("click", function () {
        $(".tab-order").addClass("active-tab");
        $(".tab-deal").removeClass("active-tab");

        $("#chart-order").addClass("active-content");
        $("#chart-deal").removeClass("active-content");
    });

    $('#cryptoTab').on('click', function () {
        toggleTable('crypto', fetchCryptocurrencyData);
        $('#positionsOverlay').hide();
        $('#historyOverlay').hide();
        $('#ordersOverlay').hide();
    });

    $('#forexTab').on('click', function () {
        toggleTable('forex', fetchForexData);
        $('#positionsOverlay').hide();
        $('#historyOverlay').hide();
        $('#ordersOverlay').hide();
    });

    $('#stocksTab').on('click', function () {
        toggleTable('stocks', fetchStocksData);
        $('#positionsOverlay').hide();
        $('#historyOverlay').hide();
        $('#ordersOverlay').hide();
    });

    $('#commoditiesTab').on('click', function () {
        toggleTable('commodities', fetchCommoditiesData);
        $('#positionsOverlay').hide();
        $('#historyOverlay').hide();
        $('#ordersOverlay').hide();
    });

    function toggleTable(tableType, fetchData) {
        const tableContainer = $('#cryptoTableContainer');
        
        tableContainer.empty();
        
        fetchData(tableType);
        
        tableContainer.show();
    }

    let selectedSymbol = '';

    async function fetchCryptocurrencyData() {
        const apiUrl = 'https://api.twelvedata.com/price?symbol=BTC/USD,ETH/USD,SOL/USD,DOGE/USD,XRP/USD,ADA/USD,LTC/USD,XLM/USD,LINK/USD&apikey=58102220f146405c939ceec954eab48e';
        const spreadPercent = 0.001;

        try {
            const response = await fetch(apiUrl);
            const data = await response.json();

            const tableContainer = $('#cryptoTableContainer');
            tableContainer.empty();

            const table = $('<table>').addClass('crypto-table');
            const headerRow = $('<tr>');
            headerRow.append('<th>Cryptocurrency</th><th>Sell</th><th>Buy</th>');
            table.append(headerRow);

            cryptoSymbols.forEach(symbol => {
                const price = parseFloat(data[symbol]?.price) || 0;
                const buyPrice = price * (1 + spreadPercent / 2);
                const sellPrice = price * (1 - spreadPercent / 2);

                cryptoPrices[symbol] = { price, buyPrice, sellPrice };

                const safeId = symbol.replace(/\//g, "_");
                const row = $('<tr>').attr('id', safeId);
                const nameCell = $('<td>').text(symbol);
                const sellCell = $('<td>').addClass('sell').text(`$${sellPrice.toFixed(2)}`);
                const buyCell = $('<td>').addClass('buy').text(`$${buyPrice.toFixed(2)}`);

                row.append(nameCell, sellCell, buyCell);

                row.on('click', function() {
                    selectedSymbol = symbol;
                    $('#size-number').val(0);
                    const cryptoSymbol = symbol.replace('/', '');
                    showChartForSymbol("BINANCE:" + cryptoSymbol);
                    $('#margin-text').text("-");
                    $('#res-pos').text("-");
                    selectedCell = null;
                    
                    $('.buy-sell-cell').removeClass('active');

                    const prices = cryptoPrices[symbol];
                    if (prices) {
                        $('#buyPrice').text(`$${prices.buyPrice.toFixed(2)}`);
                        $('#sellPrice').text(`$${prices.sellPrice.toFixed(2)}`);
                    }
                });

                table.append(row);
            });

            tableContainer.append(table);
        } catch (error) {
            console.error('Greška pri inicijalnom pozivu:', error);
        }
    }

    async function fetchForexData() {
        const apiUrl = 'https://api.twelvedata.com/price?symbol=EUR/USD,USD/JPY,GBP/USD,USD/CAD,USD/CHF,AUD/USD,NZD/USD&apikey=58102220f146405c939ceec954eab48e';
        const spreadPercent = 0.001; // isti kao kod kripta

        try {
            const response = await fetch(apiUrl);
            const data = await response.json();

            const tableContainer = $('#cryptoTableContainer');
            tableContainer.empty();

            const table = $('<table>').addClass('forex-table');
            const headerRow = $('<tr>');
            headerRow.append('<th>Forex</th><th>Sell</th><th>Buy</th>');
            table.append(headerRow);

            forexSymbols.forEach(symbol => {
                const price = parseFloat(data[symbol]?.price) || 0;
                const buyPrice = price * (1 + spreadPercent / 2);
                const sellPrice = price * (1 - spreadPercent / 2);

                cryptoPrices[symbol] = { price, buyPrice, sellPrice };

                const safeId = symbol.replace(/\//g, "_");
                const row = $('<tr>').attr('id', safeId);
                const nameCell = $('<td>').text(symbol);
                const sellCell = $('<td>').addClass('sell').text(`$${sellPrice.toFixed(4)}`);
                const buyCell = $('<td>').addClass('buy').text(`$${buyPrice.toFixed(4)}`);
                row.append(nameCell, sellCell, buyCell);

                row.on('click', function() {
                    selectedSymbol = symbol;
                    $('#size-number').val(0);
                    showChartForSymbol(symbol.replace('/', ''));
                    $('#margin-text').text("-");
                    $('#res-pos').text("-");
                    selectedCell = null;
                    
                    $('.buy-sell-cell').removeClass('active');

                    const prices = cryptoPrices[symbol];
                    if (prices) {
                        $('#buyPrice').text(`$${prices.buyPrice.toFixed(4)}`);
                        $('#sellPrice').text(`$${prices.sellPrice.toFixed(4)}`);
                    }
                });

                table.append(row);
            });

            tableContainer.append(table);
        } catch (error) {
            console.error('Greška pri fetchovanju forex podataka:', error);
        }
    }

    async function fetchStocksData() {
        const apiUrl = 'https://api.twelvedata.com/price?symbol=AAPL,GOOG,AMZN,MSFT,NVDA,META,TSLA,BRK.B,JPM,WMT,V,LLY,ORCL,MA,NFLX,XOM,JNJ,COST,HD,PLTR,ABBV,PG,BAC,CVX,KO,TMUS,GE,BABA,UNH,AMD,PM,CSCO,WFC,CRM,MS,ABT&apikey=58102220f146405c939ceec954eab48e';
        const spreadPercent = 0.001;

        try {
            const response = await fetch(apiUrl);
            const data = await response.json();

            const tableContainer = $('#cryptoTableContainer');
            tableContainer.empty();

            const table = $('<table>').addClass('stocks-table');
            const headerRow = $('<tr>');
            headerRow.append('<th>Stock</th><th>Sell</th><th>Buy</th>');
            table.append(headerRow);

            stockSymbols.forEach(symbol => {
                const price = parseFloat(data[symbol]?.price) || 0;
                const buyPrice = price * (1 + spreadPercent / 2);
                const sellPrice = price * (1 - spreadPercent / 2);

                cryptoPrices[symbol] = { price, buyPrice, sellPrice };

                const safeId = symbol.replace(/\//g, "_");
                const row = $('<tr>').attr('id', safeId);
                const nameCell = $('<td>').text(symbol);
                const sellCell = $('<td>').addClass('sell').text(`$${sellPrice.toFixed(2)}`);
                const buyCell = $('<td>').addClass('buy').text(`$${buyPrice.toFixed(2)}`);
                row.append(nameCell, sellCell, buyCell);

                row.on('click', function() {
                    selectedSymbol = symbol;
                    $('#size-number').val(0);
                    showChartForSymbol(symbol);
                    $('#margin-text').text("-");
                    $('#res-pos').text("-");
                    selectedCell = null;

                    $('.buy-sell-cell').removeClass('active');

                    const prices = cryptoPrices[symbol];
                    if (prices) {
                        $('#buyPrice').text(`$${prices.buyPrice.toFixed(2)}`);
                        $('#sellPrice').text(`$${prices.sellPrice.toFixed(2)}`);
                    }
                });

                table.append(row);
            });

            tableContainer.append(table);
        } catch (error) {
            console.error('Greška pri fetchovanju stock podataka:', error);
        }
    }

    async function fetchCommoditiesData() {
        const spreadPercent = 0.001;

        try {
            const apiUrl = `https://api.twelvedata.com/price?symbol=${commoditySymbols.join(',')}&apikey=58102220f146405c939ceec954eab48e`;
            const response = await fetch(apiUrl);
            const data = await response.json();

            const tableContainer = $('#cryptoTableContainer');
            tableContainer.empty();

            const table = $('<table>').addClass('commodities-table');
            const headerRow = $('<tr>');
            headerRow.append('<th>Commodity</th><th>Sell</th><th>Buy</th>');
            table.append(headerRow);

            const commodityPrices = {};

            commoditySymbols.forEach(symbol => {
                const price = parseFloat(data[symbol]?.price);

                if (isNaN(price)) {
                    console.warn(`Commodity symbol ${symbol} nije pronađen u API-ju.`);
                    return;
                }

                const buyPrice = price * (1 + spreadPercent / 2);
                const sellPrice = price * (1 - spreadPercent / 2);

                cryptoPrices[symbol] = { price, buyPrice, sellPrice };

                const safeId = symbol.replace(/\//g, "_");
                const row = $('<tr>').attr('id', safeId);

                const displayName = getReadableCommodity(symbol);
                const nameCell = $('<td>').text(displayName);
                const sellCell = $('<td>').addClass('sell').text(`$${sellPrice.toFixed(2)}`);
                const buyCell = $('<td>').addClass('buy').text(`$${buyPrice.toFixed(2)}`);

                row.append(nameCell, sellCell, buyCell);

                row.on('click', function() {
                    selectedSymbol = symbol;
                    $('#size-number').val(0);
                    showChartForSymbol(symbol);
                    $('#margin-text').text("-");
                    $('#res-pos').text("-");
                    selectedCell = null;

                    $('.buy-sell-cell').removeClass('active');

                    const prices = cryptoPrices[symbol];
                    if (prices) {
                        $('#buyPrice').text(`$${prices.buyPrice.toFixed(2)}`);
                        $('#sellPrice').text(`$${prices.sellPrice.toFixed(2)}`);
                    }
                });

                table.append(row);
            });
            tableContainer.append(table);
        } catch (error) {
            console.error('Greška pri fetchovanju commodity podataka:', error);
        }
    }

    // Socket handlers are now set up in setupSocketHandlers() function above

    function handleSocketData(data) {
        if (data.symbol && data.price) {
            updateCryptoPrice(data.symbol, parseFloat(data.price), selectedSymbol);
        }

        if (data.action === 'update_table') {
            loadDeals();
            loadOrders();
            refreshUserBalance();
        }
    }

    function refreshUserBalance() {
        $.ajax({
            url: 'php/getUserBalance.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const newBalance = parseFloat(response.balance);

                    const formattedBalance = newBalance.toLocaleString('en-US', { style: 'currency', currency: 'USD', minimumFractionDigits: 2, maximumFractionDigits: 2 });

                    $('#user-balance').text(formattedBalance);

                    $('#user-balance').data('balance', newBalance);

                    $('#user-available').text(formattedBalance);

                } else {
                    console.error('Failed to refresh balance:', response.message);
                }
            },
            error: function(err) {
                console.error('AJAX error refreshing balance:', err);
            }
        });
    }


    function updateCryptoPrice(symbol, price, selectedSymbol) {
        const spreadPercent = 0.001;

        if (!cryptoPrices[symbol]) {
            cryptoPrices[symbol] = {};
        }

        const prevPrice = parseFloat(cryptoPrices[symbol].price) || price;
        const buyPrice = price * (1 + spreadPercent / 2);
        const sellPrice = price * (1 - spreadPercent / 2);

        cryptoPrices[symbol].price = price;
        cryptoPrices[symbol].buyPrice = buyPrice;
        cryptoPrices[symbol].sellPrice = sellPrice;

        updateDealsTableLive(symbol, price);

        const safeId = symbol.replace(/\//g, "_");
        const row = $(`#${safeId}`);

        const isForex = forexSymbols.includes(symbol);
        const formatDigits = isForex ? 4 : 2;

        if (row.length > 0) {
            row.find('.buy').text(`$${buyPrice.toFixed(formatDigits)}`);
            row.find('.sell').text(`$${sellPrice.toFixed(formatDigits)}`);

            const color = price > prevPrice ? 'green' : price < prevPrice ? 'red' : 'black';
            row.find('.buy').css('color', color);
            row.find('.sell').css('color', color);
        }

        if (selectedSymbol === symbol) {
            $('#buyPrice').text(`$${buyPrice.toFixed(formatDigits)}`);
            $('#sellPrice').text(`$${sellPrice.toFixed(formatDigits)}`);
            calculateValue();
        }
    }


    

    $('.crypto-table tr').on('click', function() {
        const symbol = $(this).attr('id');
        selectedSymbol = symbol;

        const initialPrice = cryptoPrices[symbol]?.price;

        if (initialPrice) {
            currentPrice = parseFloat(initialPrice);
            updatePricesBasedOnSize();
        } else {
            console.log("Cena za simbol nije dostupna još uvek, čekam WebSocket podatke...");
        }
        showChartForSymbol(symbol);
    });


    function updatePricesBasedOnSize() {
        const size = parseFloat($('#size-number').val()) || 0;

        if (currentPrice > 0) {
            const sellPrice = (currentPrice - size).toFixed(2);
            const buyPrice = (currentPrice + size).toFixed(2);

            $('#sellPrice').text(`$${sellPrice}`);
            $('#buyPrice').text(`$${buyPrice}`);
        }
    }

    $('#size-number').on('input', function() {
        updatePricesBasedOnSize();
    });

    function showChartForSymbol(symbol) {
        const chartContainer = $('#cryptoChartContainer');
        chartContainer.show();

        const formattedSymbol = symbol.replace('/', '');

        new TradingView.widget({
            "autosize": true,
            "symbol": `${formattedSymbol}`,
            "interval": "D",
            "timezone": "America/New_York",
            "theme": "light",
            "style": "1",
            "locale": "en",
            "toolbar_bg": "#f1f3f6",
            "enable_publishing": false,
            "withdateranges": true,
            "hide_side_toolbar": false,
            "allow_symbol_change": true,
            "container_id": "tradingview-chart"
        });
    }

    function calculateValue() {
        const size = parseFloat($('#size-number').val()) || 0;
        if (!selectedCell || !selectedSymbol) return;

        let price = 0;
        let result = 0;

        const prices = cryptoPrices[selectedSymbol] || forexSpecs[selectedSymbol];
        if (!prices) return;

        price = selectedCell === 'buy' ? prices.buyPrice : prices.sellPrice;

        if (forexSpecs[selectedSymbol]) {
            const lotSize = forexSpecs[selectedSymbol].lotSize;
            if (selectedSymbol.startsWith("USD/")) {
                result = (size * lotSize * price * 0.01)/price;
            }else{
                result = size * lotSize * price * 0.01;
            }
        } else if (commodityLotSizes[selectedSymbol]) {
            const lotSize = commodityLotSizes[selectedSymbol];
            result = size * lotSize * price * 0.03;
        } else if (stockSymbols.includes(selectedSymbol)) {
            const lotSize = 100;
            result = size * lotSize * price * 0.05;
        } else {
            result = size * price * 0.1;
        }

        $('#margin-text').text("US$" + result.toFixed(2));
        $('#res-pos').text("+" + size);
    }



   $('#cell-buy').on('click', function() {
        selectedCell = 'buy';
        $('.buy-sell-cell').removeClass('active buy sell');
        $(this).addClass('active buy');
        calculateValue();
    });

    $('#cell-sell').on('click', function() {
        selectedCell = 'sell';
        $('.buy-sell-cell').removeClass('active buy sell');
        $(this).addClass('active sell');
        calculateValue();
    });

    $('#order-cell-buy').on('click', function() {
        selectedCell = 'buy';
        $('.buy-sell-cell').removeClass('active buy sell');
        $(this).addClass('active buy');
        calculateValue();
    });

    $('#order-cell-sell').on('click', function() {
        selectedCell = 'sell';
        $('.buy-sell-cell').removeClass('active buy sell');
        $(this).addClass('active sell');
        calculateValue();
    });


    $('#size-number').on('input', function() {
    calculateValue();
    });

    $('#place-deal-button').on('click', function() {

        let balanceText = $('#user-balance').text().trim();
        let balance = parseFloat(balanceText.replace(/[^0-9.-]+/g, "")) || 0;
        const sizeInput = parseFloat($('#size-number').val()) || 0;

        let availableText = $('#user-available').text().trim();
        let available = parseFloat(availableText.replace(/[^0-9.-]+/g, "")) || 0;

        if (!selectedCell || !selectedSymbol) return;

        const prices = cryptoPrices[selectedSymbol];
        if (!prices) return;

        let openingPrice;
        let transactionType;
        
        if (selectedCell === 'buy') {
            openingPrice = parseFloat($('#buyPrice').text().replace('$', '').trim()) || 0;
            transactionType = 'buy';
        } else if (selectedCell === 'sell') {
            openingPrice = parseFloat($('#sellPrice').text().replace('$', '').trim()) || 0;
            transactionType = 'sell';
        }

        if (!openingPrice) {
            alert("Cena nije validna.");
            return;
        }

        let result = 0;

        if (!isNaN(sizeInput) && !isNaN(openingPrice)) {

            if (forexSpecs[selectedSymbol]) {

                result = sizeInput * forexSpecs[selectedSymbol].lotSize * openingPrice * 0.01;

                if (selectedSymbol.startsWith("USD/"))
                    result /= openingPrice;

            } else if (commodityLotSizes[selectedSymbol]) {

                result = sizeInput * commodityLotSizes[selectedSymbol] * openingPrice * 0.03;

            } else if (stockSymbols.includes(selectedSymbol)) {

                result = sizeInput * 100 * openingPrice * 0.05;

            } else {

                result = Math.abs(sizeInput) * openingPrice * 0.1;
            }
        }
        $('#margin-text').text("US$" + result.toFixed(2));
        $('#res-pos').text("+" + sizeInput);

        

            let userId = $('body').data('user-id');
            let size = selectedCell === 'buy' ? sizeInput : -Math.abs(sizeInput);
            let symbol = selectedSymbol;

            let stopAt = parseFloat($('#stop-deal').val()) || 0;
            let limitAt = parseFloat($('#limit-deal').val()) || 0;

            if(sizeInput == 0){
                showPlaceDealError("Size cannot be 0.");
                return;
            }

            if(stopAt != 0 && stopAt > openingPrice){
                showPlaceDealError("Stop loss cannot be higher than current price.");
                return;
            }

            if(limitAt != 0 && limitAt < openingPrice){
                showPlaceDealError("Take profit cannot be lower than current price.");
                return;
            }

            if (result > available) {
                showPlaceDealError("Insufficient available funds");
                return;
            }

            $.ajax({
                url: 'php/processDeal.php',
                method: 'POST',
                data: {
                    user_id: userId,
                    size: size,
                    opening: openingPrice,
                    symbol: symbol,
                    margin: result,
                    transaction_type: transactionType,
                    stop_at: stopAt, 
                    limit_at: limitAt
                },
                success: function(response) {
                    try {
                        const data = (typeof response === "string") ? JSON.parse(response) : response;

                        if (data.success) {
                            localStorage.setItem('positionsVisible', 'true');
                            location.reload();
                        } else {
                            showPlaceDealError("Insufficient available funds");
                        }
                    } catch (e) {
                        console.error("Greška pri parsiranju server odgovora:", e);
                        alert("Došlo je do greške u odgovoru servera.");
                    }
                },
                error: function(xhr, status, error) {
                    alert("Došlo je do greške pri slanju podataka.");
                    console.error(error);
                }
            });
        
    });

    $('#place-order-button').on('click', function() {
        let userId = $('body').data('user-id');
        let sizeInput = parseFloat($('#order-size-number').val()) || 0;
        let orderPrice = parseFloat($('#order-price').val()) || 0;
        let stopAt = parseFloat($('#stop-order').val()) || 0;
        let limitAt = parseFloat($('#limit-order').val()) || 0;

        let availableText = $('#user-available').text().trim();
        let available = parseFloat(availableText.replace(/[^0-9.-]+/g, "")) || 0;

        if (!selectedCell || !selectedSymbol) {
            showPlaceDealErrorOrder("Please select BUY or SELL.");
            return;
        }

        if (!orderPrice || orderPrice <= 0) {
            showPlaceDealErrorOrder("Order price must be entered.");
            return;
        }

        // -----------------------------------------
        // STOP LOSS / TAKE PROFIT PROVERE
        // -----------------------------------------
        if (stopAt !== 0 && stopAt > orderPrice) {
            showPlaceDealErrorOrder("Stop loss cannot be higher than order price.");
            return;
        }

        if (limitAt !== 0 && limitAt < orderPrice) {
            showPlaceDealErrorOrder("Take profit cannot be lower than order price.");
            return;
        }

        // -----------------------------------------
        // MARGIN KALKULACIJA (ISTA KAO PLACE DEAL)
        // -----------------------------------------
        let margin = 0;

        if (!isNaN(sizeInput) && !isNaN(orderPrice)) {

            if (forexSpecs[selectedSymbol]) {

                margin = sizeInput * forexSpecs[selectedSymbol].lotSize * orderPrice * 0.01;

                if (selectedSymbol.startsWith("USD/"))
                    margin /= orderPrice;

            } else if (commodityLotSizes[selectedSymbol]) {

                margin = sizeInput * commodityLotSizes[selectedSymbol] * orderPrice * 0.03;

            } else if (stockSymbols.includes(selectedSymbol)) {

                margin = sizeInput * 100 * orderPrice * 0.05;

            } else {

                margin = Math.abs(sizeInput) * orderPrice * 0.1;
            }
        }

        // -----------------------------------------
        // AVAILABLE FUNDS PROVERA
        // -----------------------------------------
        if (margin > available) {
            showPlaceDealErrorOrder("Insufficient available funds");
            return;
        }

        // -----------------------------------------
        // FINAL SIZE I TRANSACTION TYPE
        // -----------------------------------------
        let transactionType = selectedCell === 'buy' ? 'buy' : 'sell';

        let finalSize = selectedCell === 'buy'
            ? sizeInput
            : -Math.abs(sizeInput);

        // -----------------------------------------
        // AJAX — SLANJE ORDERA
        // -----------------------------------------
        $.ajax({
            url: 'php/processOrder.php',
            method: 'POST',
            data: {
                user_id: userId,
                symbol: selectedSymbol,
                size: finalSize,
                order_price: orderPrice,
                margin: margin,
                transaction_type: transactionType,
                stop_at: stopAt,
                limit_at: limitAt
            },
            success: function(response) {
                try {
                    const data = JSON.parse(response);

                    if (data.success) {
                        localStorage.setItem('ordersVisible', 'true');
                        location.reload();
                    } else {
                        showPlaceDealErrorOrder("Order rejected.");
                    }
                } catch (e) {
                    showPlaceDealErrorOrder("Server response error.");
                }
            },
            error: function(xhr, status, error) {
                showPlaceDealError("Error processing order.");
            }
        });

    });

     function loadDeals() {
        $.ajax({
            url: 'php/getDeals.php',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data.success && data.deals) {
                    renderDealsTable(data.deals);
                } else {
                   $('#chart-position').html(`
                        <div class="empty-state">
                            <div class="empty-icon">📭</div>
                            <p class="empty-title">No deals found</p>
                            <p class="empty-subtitle">You currently have no open positions.</p>
                        </div>
                    `);
                }
            },
            error: function(xhr, status, error) {
                $('#chart-position').html('Error loading deals.');
                console.error(error);
            }
        });
    }

    function renderDealsTable(deals) {
        let tableHtml = '<table><thead><tr>' +
            '<th>Symbol</th>' +
            '<th>Size</th>' +
            '<th>Opening Price</th>' +
            '<th>Latest</th>' +
            '<th>Profit/Loss</th>' +
            '<th>Stop At</th>' +
            '<th>Limit At</th>' +
            '<th>Close Position</th>' +
            '</tr></thead><tbody>';

        deals.forEach(function(deal) {
            let latestPrice = '-';
            if (cryptoPrices[deal.symbol] && cryptoPrices[deal.symbol].price) {
                latestPrice = cryptoPrices[deal.symbol].price.toFixed(2);
            }

            const formattedSize = Math.abs(deal.size).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

            const formattedOpeningPrice = parseFloat(deal.opening).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 4 });

            const formattedLatestPrice = latestPrice === '-' ? latestPrice : parseFloat(latestPrice).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

            const formattedPL = '-';

            const stopAt = deal.stop_at && parseFloat(deal.stop_at) !== 0 ? parseFloat(deal.stop_at).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : 'N/A';
            const limitAt = deal.limit_at && parseFloat(deal.limit_at) !== 0 ? parseFloat(deal.limit_at).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : 'N/A';

            const displayName = commodityLotSizes[deal.symbol] ? getReadableCommodity(deal.symbol) : deal.symbol;

            tableHtml += `<tr data-deal-id="${deal.deal_id}" data-symbol="${deal.symbol}" data-size="${deal.size}" data-opening="${deal.opening}">
                <td>${displayName}</td>
                <td>${formattedSize} (${deal.transaction_type.toUpperCase()})</td>
                <td>${formattedOpeningPrice}</td>
                <td class="latest-price">${formattedLatestPrice}</td>
                <td class="pl">${formattedPL}</td>
                <td>${stopAt}</td>
                <td>${limitAt}</td>
                <td>
                    <button class="sell-btn" data-deal-id="${deal.deal_id}" data-symbol="${deal.symbol}">Close</button>
                </td>
            </tr>`;
        });

        tableHtml += '</tbody></table>';

        $('#chart-position').html(tableHtml);
    }




    $('#chart-position').on('click', '.sell-btn', function() {
        const dealId = $(this).data('deal-id');
        const row = $(this).closest('tr');
        const symbol = $(this).data('symbol');
        const size = parseFloat(row.data('size'));
        const opening = parseFloat(row.data('opening'));
        const latestPrice = parseFloat(
            row.find('.latest-price').text().replace(/,/g, '')
        ) || 0;

        console.log('Deal ID:', dealId);
        console.log('Symbol:', symbol);
        console.log('Size:', size);
        console.log('Opening Price:', opening);
        console.log('Latest Price:', latestPrice);

        $.ajax({
            url: 'php/closePosition.php',
            method: 'POST',
            data: {
                deal_id: dealId,
                symbol: symbol,
                size: size,
                openingPrice: opening,
                latestPrice: latestPrice
            },
            success: function(response) {
                const responseJson = JSON.parse(response);

                localStorage.setItem('positionsVisible', 'true');

                location.reload();
            },
            error: function(xhr, status, error) {
                alert("Error closing position.");
                console.error(error);
            }
        });
    });

    $('#positionsTableContainer').on('click', '.sell-btn', function() {
        const dealId = $(this).data('deal-id');
        const row = $(this).closest('tr');
        const symbol = $(this).data('symbol');
        const size = parseFloat(row.data('size'));
        const opening = parseFloat(row.data('opening'));
        const latestPrice = parseFloat(
            row.find('.latest-price').text().replace(/,/g, '')
        ) || 0;

        console.log('Deal ID:', dealId);
        console.log('Symbol:', symbol);
        console.log('Size:', size);
        console.log('Opening Price:', opening);
        console.log('Latest Price:', latestPrice);

        $.ajax({
            url: 'php/closePosition.php',
            method: 'POST',
            data: {
                deal_id: dealId,
                symbol: symbol,
                size: size,
                openingPrice: opening,
                latestPrice: latestPrice
            },
            success: function(response) {
                const responseJson = JSON.parse(response);

                localStorage.setItem('positionsVisible', 'true');

                location.reload();
            },
            error: function(xhr, status, error) {
                alert("Error closing position.");
                console.error(error);
            }
        });
    });


    function updateDealsTableLive(symbol, latestPrice) {
        let totalPL = 0;
        let totalMargin = 0;
        const spreadPercent = 0.001;

        const buyPrice = latestPrice * (1 + spreadPercent / 2);
        const sellPrice = latestPrice * (1 - spreadPercent / 2);

        let hasRelevantPosition = false;

        $('#chart-position tr').each(function() {
                const rowSymbol = $(this).data('symbol');
                const size = parseFloat($(this).data('size'));
                const opening = parseFloat($(this).data('opening'));
                let rowLatest = parseFloat($(this).data('latest')) || opening;

                if (rowSymbol === symbol) {
                    hasRelevantPosition = true;
                    rowLatest = sellPrice; // nova cena
                    $(this).data('latest', rowLatest);

                    const isForex = forexSymbols.includes(rowSymbol);
                    const formatDigits = isForex ? 4 : 2;

                    $(this).find('.latest-price').text(rowLatest.toFixed(formatDigits));
                }

                // ----------------------------
                // PROFIT/LOSS
                // ----------------------------
                let profitLoss = 0;

                if (!isNaN(size) && !isNaN(opening)) {
                    if (forexSpecs[rowSymbol]) {
                        const lotSize = forexSpecs[rowSymbol].lotSize;
                        let pl = (rowLatest - opening) * lotSize * size;
                        if (rowSymbol.startsWith("USD/")) pl = pl / rowLatest;
                        profitLoss = pl;

                    } else if (commodityLotSizes[rowSymbol]) {
                        const lotSize = commodityLotSizes[rowSymbol];
                        profitLoss = (rowLatest - opening) * lotSize * size;

                    } else if (stockSymbols.includes(rowSymbol)) {
                        const lotSize = 100;
                        profitLoss = (rowLatest - opening) * lotSize * size;

                    } else {
                        profitLoss = (rowLatest - opening) * Math.abs(size) * 0.1;
                    }
                }

                $(this).data('pl', profitLoss);

                // ----------------------------
                // UI UPDATE P/L za pogođeni simbol
                // ----------------------------
                if (rowSymbol === symbol) {
                    const formatDigits = 2;
                    const formattedPL = profitLoss >= 0 ? `+${profitLoss.toFixed(formatDigits)}` : profitLoss.toFixed(formatDigits);
                    $(this).find('.pl').text(formattedPL);
                }

                totalPL += profitLoss;

                // ----------------------------
                // MARGIN
                // ----------------------------
                let margin = 0;
                if (!isNaN(size) && !isNaN(rowLatest)) {
                    if (forexSpecs[rowSymbol]) {
                        margin = size * forexSpecs[rowSymbol].lotSize * rowLatest * 0.01;
                        if (rowSymbol.startsWith("USD/")) margin /= rowLatest;
                    } else if (commodityLotSizes[rowSymbol]) {
                        margin = size * commodityLotSizes[rowSymbol] * rowLatest * 0.03;
                    } else if (stockSymbols.includes(rowSymbol)) {
                        margin = size * 100 * rowLatest * 0.05;
                    } else {
                        margin = Math.abs(size) * rowLatest * 0.1;
                    }
                    totalMargin += margin;
                }
        });

        if (!hasRelevantPosition) return;

        // ----------------------------
        // UI UPDATE: Margin, PL, Equity, Available, Margin Level
        // ----------------------------
        const formattedMargin = totalMargin.toLocaleString('en-US', { 
            style: 'currency', currency: 'USD', minimumFractionDigits: 2 
        });

        $('.userFunds-details').find('p:contains("Margin")').next().text(formattedMargin);
        $('#profile-margin').text("Margin: " + formattedMargin);

        const formattedPL = totalPL.toLocaleString('en-US', { 
            style: 'currency', currency: 'USD', minimumFractionDigits: 2 
        });

        $('#profitLoss').text(formattedPL);
        $('#profile-profitLoss').text("Profit/Loss: " + formattedPL);

        const funds = parseFloat($('#user-balance').data('balance')) || 0;
        const equity = funds + totalPL;

        const formattedEquity = equity.toLocaleString('en-US', {
            style: 'currency', currency: 'USD', minimumFractionDigits: 2
        });

        $('#user-equity').text(formattedEquity);
        $('#profile-equity').text("Equity: " + formattedEquity);

        const available = equity - totalMargin;

        const formattedAvailable = available.toLocaleString('en-US', {
            style: 'currency', currency: 'USD', minimumFractionDigits: 2
        });

        $('.userFunds-details').find('p:contains("Available")').next().text(formattedAvailable);
        $('#profile-available').text("Available: " + formattedAvailable);

        const marginLevel = (equity / totalMargin) * 100;
        const formattedMarginLevel = 
            (marginLevel === Infinity || isNaN(marginLevel)) 
                ? "0.00%" 
                : `${marginLevel.toFixed(2)}%`;

        $('#margin-level').text(formattedMarginLevel);
        $('#profile-marginLevel').text("Margin Level: " + formattedMarginLevel);

        if ($('#positionsOverlay').is(':visible')) {
            $('#positionsTableContainer').html($('#chart-position').html());
        }
    }

    function updateDealsTable() {
    $.ajax({
        url: 'php/getDeals.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            if (!(data.success && data.deals && data.deals.length > 0)) {
                $('#chart-position').html(`
                    <div class="empty-state">
                        <div class="empty-icon">📭</div>
                        <p class="empty-title">No deals found</p>
                        <p class="empty-subtitle">You currently have no open positions.</p>
                    </div>
                `);
                return;
            }

            const deals = data.deals;
            const symbols = [...new Set(deals.map(d => d.symbol))].join(',');

            const apiKey = '58102220f146405c939ceec954eab48e';

            $.ajax({
                url: `https://api.twelvedata.com/price?symbol=${symbols}&apikey=${apiKey}`,
                method: 'GET',
                dataType: 'json',
                success: function(pricesData) {

                    const latestPrices = {};
                    if (Array.isArray(pricesData)) {
                        pricesData.forEach(p => latestPrices[p.symbol] = parseFloat(p.price));
                    } else {
                        for (const s in pricesData) {
                            latestPrices[s] = parseFloat(pricesData[s].price);
                        }
                    }

                    deals.forEach(d => {
                        d.latest = latestPrices[d.symbol] || parseFloat(d.opening);
                    });

                    renderDealsTableInitial(deals);

                    let totalPL = 0;
                    let totalMargin = 0;

                    $("#chart-position tbody tr").each(function () {

                        const rowSymbol = $(this).attr('data-symbol'); // !!! ne data()
                        const size = parseFloat($(this).attr('data-size'));
                        const opening = parseFloat($(this).attr('data-opening'));
                        let rowLatest = parseFloat($(this).attr('data-latest'));

                        if (rowLatest === undefined || isNaN(rowLatest)) {
                            rowLatest = opening;
                        }

                        let profitLoss = 0;

                        if (!isNaN(size) && !isNaN(opening)) {

                            if (forexSpecs[rowSymbol]) {

                                let roundedLatest = rowLatest.toFixed(4);
                                const lotSize = forexSpecs[rowSymbol].lotSize;
                                const diff = roundedLatest - opening;
                                let pl = diff * lotSize * size;

                                if (rowSymbol.startsWith("USD/")) {
                                    pl = pl / rowLatest;
                                }

                                profitLoss = pl;

                            } else if (commodityLotSizes[rowSymbol]) {
                                const lotSize = commodityLotSizes[rowSymbol];
                                const diff = rowLatest - opening;
                                profitLoss = diff * lotSize * size;

                            } else if (stockSymbols.includes(rowSymbol)) {
                                const lotSize = 100;
                                const diff = rowLatest - opening;
                                profitLoss = diff * lotSize * size;

                            } else {
                                profitLoss = (rowLatest - opening) * Math.abs(size) * 0.1;
                            }

                        }

                        $(this).data('pl', profitLoss);

                        let displayPL = profitLoss;
                        if (rowSymbol.startsWith("USD/")) {
                            displayPL = profitLoss * rowLatest;
                        }

                        const formattedPL = displayPL >= 0 ? "+" + displayPL.toFixed(2) : displayPL.toFixed(2);
                        $(this).find('.pl').text(formattedPL);

                        totalPL += profitLoss;


                        if (!isNaN(size) && !isNaN(rowLatest)) {
                            let margin = 0;

                            if (forexSpecs[rowSymbol]) {
                                const lotSize = forexSpecs[rowSymbol].lotSize;
                                margin = size * lotSize * rowLatest * 0.01;

                                if (rowSymbol.startsWith("USD/")) {
                                    margin = margin / rowLatest;
                                }
                            } else if (stockSymbols.includes(rowSymbol)) {
                                margin = size * 100 * rowLatest * 0.05;
                            } else if (commodityLotSizes[rowSymbol]) {
                                margin = size * commodityLotSizes[rowSymbol] * rowLatest * 0.03;
                            } else {
                                margin = Math.abs(size) * rowLatest * 0.1;
                            }

                            totalMargin += margin;
                        }

                    });

                    const formattedMargin = totalMargin.toLocaleString('en-US', {
                        style: 'currency', currency: 'USD', minimumFractionDigits: 2
                    });

                    $('.userFunds-details').find('p:contains("Margin")')
                        .next().text(formattedMargin);
                    $('#profile-margin').text("Margin: " + formattedMargin);

                    const formattedPL = totalPL.toLocaleString('en-US', {
                        style: 'currency', currency: 'USD', minimumFractionDigits: 2
                    });

                    $('#profitLoss').text(formattedPL);
                    $('#profile-profitLoss').text("Profit/Loss: " + formattedPL);

                    const funds = parseFloat($('#user-balance').data('balance')) || 0;
                    const equity = funds + totalPL;

                    const formattedEquity = equity.toLocaleString('en-US', {
                        style: 'currency', currency: 'USD', minimumFractionDigits: 2
                    });

                    $('#user-equity').text(formattedEquity);
                    $('#profile-equity').text("Equity: " + formattedEquity);

                    const available = equity - totalMargin;

                    const formattedAvailable = available.toLocaleString('en-US', {
                        style: 'currency', currency: 'USD', minimumFractionDigits: 2
                    });

                    $('.userFunds-details').find('p:contains("Available")')
                        .next().text(formattedAvailable);
                    $('#profile-available').text("Available: " + formattedAvailable);

                    const marginLevel = (equity / totalMargin) * 100;
                    const formattedMarginLevel =
                        (!isFinite(marginLevel)) ? "0.00%" : marginLevel.toFixed(2) + "%";

                    $('#margin-level').text(formattedMarginLevel);
                    $('#profile-marginLevel').text("Margin Level: " + formattedMarginLevel);
                },

                error: function(err) {
                    console.error("TwelveData API error:", err);
                    renderDealsTableInitial(deals);
                }
            });

        },
        error: function(xhr, status, error) {
            $('#chart-position').html("Error loading deals.");
            console.error(error);
        }
    });
}


    function renderDealsTableInitial(deals) {
        let totalPL = 0;
        let totalMargin = 0;
        const spreadPercent = 0.001;

        let tableHtml = '<table><thead><tr>' +
            '<th>Symbol</th>' +
            '<th>Size</th>' +
            '<th>Opening Price</th>' +
            '<th>Latest</th>' +
            '<th>Profit/Loss</th>' +
            '<th>Stop At</th>' +
            '<th>Limit At</th>' +
            '<th>Close Position</th>' +
            '</tr></thead><tbody>';

        deals.forEach(deal => {
            const { deal_id, symbol, size, opening, transaction_type, stop_at, limit_at, latest } = deal;

            // Pretvori u broj za računicu
            const openingPrice = parseFloat(opening);
            const latestPrice = parseFloat(latest);

            const buyPrice = latestPrice * (1 + spreadPercent / 2);
            const sellPrice = latestPrice * (1 - spreadPercent / 2);
            const rowLatest = sellPrice;

            // Izračunaj profit/loss
            let profitLoss = 0;
            if (!isNaN(size) && !isNaN(openingPrice)) {

                if (forexSpecs[symbol]) {
                
                    const lotSize = forexSpecs[symbol].lotSize;
                    const diff = rowLatest - opening;
                    let pl = diff * lotSize * size;

                    if (symbol.startsWith("USD/")) {
                        pl = pl / rowLatest;
                    }

                    profitLoss = pl;

                } else if (commodityLotSizes[symbol]) {
                    const lotSize = commodityLotSizes[symbol];
                    const diff = rowLatest - opening;
                    profitLoss = diff * lotSize * size;

                } else if (stockSymbols.includes(symbol)) {
                    const lotSize = 100;
                    const diff = rowLatest - opening;
                    profitLoss = diff * lotSize * size;

                } else {
                    profitLoss = (rowLatest - opening) * Math.abs(size) * 0.1;
                }

            }

            totalPL += profitLoss;
            totalMargin += rowLatest * Math.abs(size) * 0.1;

            const formattedPL = profitLoss >= 0 ? `+${profitLoss.toFixed(2)}` : profitLoss.toFixed(2);
            const formattedSize = Math.abs(size).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            const formattedOpening = openingPrice.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 4 });
            const formattedLatest = rowLatest.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 4 });

            const formattedStop = stop_at && parseFloat(stop_at) !== 0 ? parseFloat(stop_at).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : 'N/A';
            const formattedLimit = limit_at && parseFloat(limit_at) !== 0 ? parseFloat(limit_at).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : 'N/A';

            const displayName = commodityLotSizes[symbol] ? getReadableCommodity(symbol) : symbol;

            tableHtml += `
                <tr id="deal_${deal_id}" data-symbol="${symbol}" data-size="${size}" data-opening="${openingPrice}" data-latest="${rowLatest}" data-pl="${profitLoss}">
                    <td class="symbol">${displayName}</td>
                    <td class="size">${formattedSize} (${transaction_type.toUpperCase()})</td>
                    <td class="opening">${formattedOpening}</td>
                    <td class="latest-price">${formattedLatest}</td>
                    <td class="pl">${formattedPL}</td>
                    <td>${formattedStop}</td>
                    <td>${formattedLimit}</td>
                    <td>
                        <button class="sell-btn" data-deal-id="${deal_id}" data-symbol="${symbol}">Close</button>
                    </td>
                </tr>
            `;
        });

        tableHtml += '</tbody></table>';

        $('#chart-position').html(tableHtml);

        // Update Profit/Loss, Margin, Equity, Available
        const funds = parseFloat($('#user-balance').data('balance')) || 0;

        const formattedPLTotal = totalPL.toLocaleString('en-US', { style: 'currency', currency: 'USD', minimumFractionDigits: 2, maximumFractionDigits: 2 });
        $('#profitLoss').text(formattedPLTotal);
        $('#profile-profitLoss').text("Profit/Loss: " + formattedPLTotal);

        const formattedMargin = totalMargin.toLocaleString('en-US', { style: 'currency', currency: 'USD', minimumFractionDigits: 2, maximumFractionDigits: 2 });
        $('.userFunds-details').find('p:contains("Margin")').next().text(formattedMargin);
        $('#profile-margin').text("Margin: " + formattedMargin);

        const equity = funds + totalPL;
        const formattedEquity = equity.toLocaleString('en-US', { style: 'currency', currency: 'USD', minimumFractionDigits: 2, maximumFractionDigits: 2 });
        $('#user-equity').text(formattedEquity);
        $('#profile-equity').text("Equity: " + formattedEquity);

        const available = equity - totalMargin;
        const formattedAvailable = available.toLocaleString('en-US', { style: 'currency', currency: 'USD', minimumFractionDigits: 2, maximumFractionDigits: 2 });
        $('.userFunds-details').find('p:contains("Available")').next().text(formattedAvailable);
        $('#profile-available').text("Available: " + formattedAvailable);

        const marginLevel = (equity / totalMargin) * 100;
        const formattedMarginLevel = (marginLevel === Infinity || isNaN(marginLevel))
            ? "0.00%"
            : `${marginLevel.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}%`;
        $('#margin-level').text(formattedMarginLevel);
        $('#profile-marginLevel').text("Margin Level: " + formattedMarginLevel);

        if ($('#positionsOverlay').is(':visible')) {
            $('#positionsTableContainer').html($('#chart-position').html());
        }
    }




    // loadDeals();

    $('#sideMenu a:contains("Positions")').click(function(e){
        e.preventDefault();
        $('#positionsOverlay').show();
        $('#cryptoTableContainer').hide();
        $('#cryptoChartContainer').hide();
        $('#historyOverlay').hide();
        $('#ordersOverlay').hide();

        $('#positionsTableContainer').html($('#chart-position').html());
    });

    $('#closePositions').click(function(){
        $('#positionsOverlay').hide();
    });

    $('#historyTab').on('click', function () {
        $('#positionsOverlay').hide();
        $('#cryptoTableContainer').hide();
        $('#cryptoChartContainer').hide();
        $('#ordersOverlay').hide();

        $('#historyOverlay').show();

        loadHistory();
    });

    function loadHistory() {
        $.ajax({
            url: 'php/getHistory.php',
            method: 'GET',
            success: function(response) {

                if (typeof response === "string") {
                    response = JSON.parse(response);
                }

                if (response.deals && Array.isArray(response.deals)) {
                    generateHistoryTable(response.deals);
                } else {
                    $('#historyOverlay .container').html(`
                        <div class="empty-state">
                            <div class="empty-icon">📭</div>
                            <p class="empty-title">No position history</p>
                            <p class="empty-subtitle">You position history is currently empty.</p>
                        </div>
                    `);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                alert("Error fetching history.");
            }
        });
    }

    function generateHistoryTable(deals) {
        const tableContainer = $('#historyTableContainer');
        let tableHtml = `
            <table class="history-table">
                <thead>
                    <tr>
                        <th>Symbol</th>
                        <th>Size</th>
                        <th>Opening Price</th>
                        <th>Closing Price</th>
                        <th>Transaction Type</th>
                        <th>Close Time</th>
                        <th>Profit/Loss</th>
                    </tr>
                </thead>
                <tbody>
        `;

        let totalProfitLoss = 0;

        deals.forEach(function(deal) {
            const transactionType = deal.transaction_type === 'buy' ? 'Buy' : 'Sell';
            const profitLoss = parseFloat(deal.profit_loss);

            // Formatiranje za Size
            const formattedSize = Math.abs(deal.size).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

            // Formatiranje za Opening Price
            const formattedOpeningPrice = parseFloat(deal.opening_price).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

            // Formatiranje za Closing Price
            const formattedClosingPrice = parseFloat(deal.latest_price).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

            // Formatiranje za Profit/Loss
            const formattedProfitLoss = profitLoss.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

            const displayName = commodityLotSizes[deal.symbol] ? getReadableCommodity(deal.symbol) : deal.symbol;

            tableHtml += `
                <tr>
                    <td>${displayName}</td>
                    <td>${formattedSize}</td>
                    <td>${formattedOpeningPrice}</td>
                    <td>${formattedClosingPrice}</td>
                    <td>${transactionType}</td>
                    <td>${deal.close_time}</td>
                    <td>${formattedProfitLoss}</td>
                </tr>
            `;

            totalProfitLoss += profitLoss;
        });

        tableHtml += `
                </tbody>
            </table>
            <div class="total-profit-loss">
                Total Profit/Loss: <span class="profit-total">${totalProfitLoss.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</span>
            </div>
        `;

        tableContainer.html(tableHtml);
    }



    $('#ordersTab').on('click', function () {
        $('#positionsOverlay').hide();
        $('#cryptoTableContainer').hide();
        $('#cryptoChartContainer').hide();
        $('#historyOverlay').hide();

        $('#ordersOverlay').show();

        loadOrders();
    });

    function loadOrders() {
        $.ajax({
            url: 'php/getOrders.php',
            method: 'GET',
            success: function(response) {

                if (typeof response === "string") {
                    response = JSON.parse(response);
                }

                if (response.orders && Array.isArray(response.orders)) {
                    generateOrdersTable(response.orders);
                } else {
                    $('#ordersOverlay .container').html(`
                        <div class="empty-state">
                            <div class="empty-icon">📭</div>
                            <p class="empty-title">No open orders</p>
                            <p class="empty-subtitle">You currently have no open orders.</p>
                        </div>
                    `);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
                alert("Error fetching orders.");
            }
        });
    }

    function generateOrdersTable(orders) {
        const tableContainer = $('#ordersTableContainer');

        let tableHtml = `
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Symbol</th>
                        <th>Size</th>
                        <th>Order Price</th>
                        <th>Transaction Type</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
        `;

        orders.forEach(function(order) {
            const type = order.transaction_type === 'buy' ? 'Buy' : 'Sell';

            const displayName = commodityLotSizes[order.symbol] ? getReadableCommodity(order.symbol) : order.symbol;

            tableHtml += `
                <tr>
                    <td>${displayName}</td>
                    <td>${Math.abs(order.size).toFixed(2)}</td>
                    <td>${order.order_price}</td>
                    <td>${type}</td>
                    <td>${order.created_at}</td>
                </tr>
            `;
        });

        tableHtml += `
                </tbody>
            </table>
        `;

        tableContainer.html(tableHtml);
        tableContainer.show();
    }

    function updateMargin() {
        let size = parseFloat($('#order-size-number').val());
        let orderPrice = parseFloat($('#order-price').val());

        if (!isNaN(size) && !isNaN(orderPrice)) {
            let margin = 0;

            if (forexSpecs[selectedSymbol]) {
                const lotSize = forexSpecs[selectedSymbol].lotSize;
                if (selectedSymbol.startsWith("USD/")) {
                    margin = (size * lotSize * orderPrice * 0.01) / orderPrice;
                } else {
                    margin = size * lotSize * orderPrice * 0.01;
                }

            } else if (commodityLotSizes[selectedSymbol]) {
                
                const lotSize = commodityLotSizes[selectedSymbol];
                margin = size * lotSize * orderPrice * 0.03;

            } else if (stockSymbols.includes(selectedSymbol)) {
                const lotSize = 100;
                margin = size * lotSize * orderPrice * 0.05;

            } else {
                margin = size * orderPrice * 0.1;
            }

            $('#order-margin-text').text(margin.toFixed(2));
        } else {
            $('#order-margin-text').text('-');
        }
    }




    $('#order-size-number, #order-price').on('input', function () {
        updateMargin();
    });



    $('#hamburgerMenu').on('click', function() {
        $('#sideMenu').toggleClass('open');
    });

    $('#sideMenu a').on('click', function() {
        $('#sideMenu').removeClass('open');
        if ($(window).width() <= 768) {
            $('#cryptoChartContainer').hide();
        }
    });

    $('#cryptoTableContainer').on('click', 'tr', function() {
        if ($(window).width() <= 768) {
            $('#cryptoTableContainer').hide();  
        }
    });

    $('#profileIcon').on('click', function() {
        $('#profileDropdown').toggle(); 
    });

    $(document).on('click', function(event) {
        if (!$(event.target).closest('#profileIcon').length && !$(event.target).closest('#profileDropdown').length) {
            $('#profileDropdown').hide(); 
        }
    });


});
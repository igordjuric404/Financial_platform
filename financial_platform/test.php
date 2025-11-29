<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real-Time Stock Prices</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            max-width: 900px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .price {
            margin: 10px 0;
            font-size: 20px;
            color: #333;
        }
        .symbol {
            font-weight: bold;
        }
        .price-value {
            color: green; /* Default color is green */
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Real-Time Stock Prices</h1>

    <div id="prices">
        <!-- Ovdje će se prikazivati real-time cene -->
    </div>

    <script>
        // Dynamic WebSocket URL based on current protocol and hostname
        const wsProtocol = window.location.protocol === 'https:' ? 'wss:' : 'ws:';
        const wsHost = window.location.hostname;
        let socket = new WebSocket(`${wsProtocol}//${wsHost}/ws`);
        let stockPrices = {};  // Držimo cene u ovom objektu

        // Lista simbola za koje pratimo cene (uključujući ETH/USD)
        const symbols = ['AAPL', 'TRP', 'QQQ', 'EUR/USD', 'USD/JPY', 'BTC/USD', 'ETH/BTC', 'ETH/USD'];

        // Funkcija za inicijalni HTTP poziv i prikaz cena
        async function fetchInitialPrices() {
            const apiUrl = 'https://api.twelvedata.com/price?symbol=AAPL,TRP,QQQ,EUR/USD,USD/JPY,BTC/USD,ETH/BTC,ETH/USD&apikey=58102220f146405c939ceec954eab48e'; // Zameniti sa tvojim API ključem

            try {
                const response = await fetch(apiUrl);
                const data = await response.json();

                // Inicijalno prikazivanje simbola sa njihovim početnim vrednostima
                symbols.forEach(symbol => {
                    const price = data[symbol]?.price || 'Loading...';
                    stockPrices[symbol] = { price: price, element: null };

                    const priceElement = document.createElement("div");
                    priceElement.classList.add("price");
                    priceElement.innerHTML = `<span class="symbol">${symbol}:</span> <span class="price-value">${price}</span>`;
                    document.getElementById("prices").appendChild(priceElement);
                    stockPrices[symbol].element = priceElement;
                });
            } catch (error) {
                console.error('Greška pri inicijalnom pozivu:', error);
            }
        }

        socket.onopen = function(event) {
            console.log("Povezan sa serverom!");

            // Pošaljemo zahtev za sve simbole odmah pri povezivanju
            const request = {
                action: 'subscribe',
                params: {
                    symbols: 'AAPL,TRP,QQQ,EUR/USD,USD/JPY,BTC/USD,ETH/BTC,ETH/USD'  // Dodaj ETH/USD ovde
                }
            };
            socket.send(JSON.stringify(request));

            // Inicijalno prikazivanje cena sa API-ja
            fetchInitialPrices();
        };

        socket.onmessage = function(event) {
            console.log("Primio poruku od servera:", event.data);

            if (typeof event.data === "string") {
                console.log("Primljeni podaci kao string:", event.data);
                try {
                    const data = JSON.parse(event.data);
                    console.log("Parsed JSON data:", data);

                    // Ažuriraj cenu samo za simbol koji je došao
                    if (data.symbol && data.price) {
                        const currentPrice = parseFloat(data.price);
                        const previousPrice = parseFloat(stockPrices[data.symbol].price);
                        stockPrices[data.symbol].price = currentPrice;

                        // Ažuriraj cenu na ekranu
                        const priceElement = stockPrices[data.symbol].element.querySelector('.price-value');
                        priceElement.textContent = `${data.price} USD`;

                        // Promena boje u zavisnosti od toga da li je cena porasla ili opala
                        if (currentPrice > previousPrice) {
                            priceElement.style.color = 'green'; // Ako je cena porasla
                        } else if (currentPrice < previousPrice) {
                            priceElement.style.color = 'red'; // Ako je cena opala
                        }
                    } else {
                        console.log("Podaci nemaju simbol i cenu:", data);
                    }
                } catch (e) {
                    console.error("Greška pri parsiranju JSON-a:", e);
                }
            } else if (event.data instanceof Blob) {
                console.log("Primljeni podaci su Blob:", event.data);
                const reader = new FileReader();
                reader.onload = function() {
                    const blobData = reader.result;
                    console.log("Blob sadržaj:", blobData);
                    try {
                        const data = JSON.parse(blobData);
                        console.log("Parsed JSON data from Blob:", data);

                        if (data.symbol && data.price) {
                            const currentPrice = parseFloat(data.price);
                            const previousPrice = parseFloat(stockPrices[data.symbol].price);
                            stockPrices[data.symbol].price = currentPrice;

                            // Ažuriraj cenu na ekranu
                            const priceElement = stockPrices[data.symbol].element.querySelector('.price-value');
                            priceElement.textContent = `${data.price} USD`;

                            // Promena boje u zavisnosti od toga da li je cena porasla ili opala
                            if (currentPrice > previousPrice) {
                                priceElement.style.color = 'green'; // Ako je cena porasla
                            } else if (currentPrice < previousPrice) {
                                priceElement.style.color = 'red'; // Ako je cena opala
                            }
                        } else {
                            console.log("Podaci nemaju simbol i cenu:", data);
                        }
                    } catch (e) {
                        console.error("Greška pri parsiranju Blob-a:", e);
                    }
                };
                reader.readAsText(event.data);
            } else {
                console.log("Neobičan tip podataka primljen:", event.data);
            }
        };

        socket.onclose = function(event) {
            console.log("Konekcija zatvorena!");
        };
    </script>
</div>

</body>
</html>
<?php
session_start();

if (!isset($_SESSION['user']) || !is_array($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$balance = (float) $_SESSION['user']['balance'];

$formattedBalance = number_format($balance, 2, '.', ',');

$balanceWithAdjustment = $balance - 1000;
$formattedAdjustedBalance = number_format($balanceWithAdjustment, 2, '.', ',');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trading Platform</title>
    <link rel="stylesheet" href="platform.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body data-user-id="<?php echo $_SESSION['user']['userId']; ?>">

    <!-- Top Bar -->
    <div id="topBar">
        <div class="brand">
            <p><?php echo $_SESSION['user']['firstName'] . ' ' . $_SESSION['user']['lastName']; ?></p>
        </div>
        <div class="userFunds">
            <div class="userFunds-details">
                <p class="userFunds-name">Funds</p>
                <p class="userFunds-number" id="user-balance" data-balance="<?php echo $formattedBalance; ?>">
                    <?php echo $formattedBalance; ?>
                </p>
            </div>
            <div class="userFunds-details">
                <p class="userFunds-name">Profit/Loss</p>
                <p class="userFunds-number" id="profitLoss">$0.00</p>
            </div>
            <div class="userFunds-details">
                <p class="userFunds-name">Margin</p>
                <p class="userFunds-number">$0.00</p>
            </div>
            <div class="userFunds-details">
                <p class="userFunds-name">Available</p>
                <p class="userFunds-number" id="user-available">$<?php echo $_SESSION['user']['balance'] ?></p>
            </div>
            <div class="userFunds-details">
                <p class="userFunds-name">Equity</p>
                <p class="userFunds-number" id="user-equity">$0.00</p>
            </div>
            <div class="userFunds-details">
                <p class="userFunds-name">Margin level</p>
                <p class="userFunds-number" id="margin-level">$0.00</p>
            </div>
            
        </div>

        <span id="hamburgerMenu" class="hidden-desk">&#9776;</span>

        <!-- Profile Icon -->
        <div id="profileIcon" class="hidden-desk">
            <p><?php echo $_SESSION['user']['firstName'] . ' ' . $_SESSION['user']['lastName']; ?></p>
        </div>

        <!-- Profile Dropdown Menu (Hidden by default) -->
        <div id="profileDropdown" class="hidden-desk">
            <p id="profile-funds">Funds: $<?php echo $formattedBalance; ?></p>
            <p id="profile-margin">Margin: $0.00</p>
            <p id="profile-profitLoss">Profit/Loss: $0.00</p>
            <p id="profile-available">Available: $<?php echo $_SESSION['user']['balance']; ?></p>
            <p id="profile-equity">Equity: $0.00</p>
            <p id="profile-marginLevel">Margin Level: $0.00</p>
        </div>
    </div>

    <!-- Main Container -->
    <div id="mainContainer">

        <!-- Left Navigation Menu -->
       <nav id="sideMenu" class="open">
            <div class="menu">
                <ul>
                    <a href="#" id="cryptoTab"><li>Cryptocurrency</li></a>
                    <a href="#" id="forexTab"><li>Forex</li></a>
                    <a href="#" id="stocksTab"><li>Stocks</li></a>
                    <a href="#" id="commoditiesTab"><li>Commodities</li></a>
                </ul>
                <ul>
                    <a href="#" id="positionsTab"><li>Positions</li></a>
                    <a href="#" id="ordersTab"><li>Orders</li></a>
                    <a href="#" id="historyTab"><li>History</li></a>
                </ul>
            </div>
            <a href="clientportal.php" class="dashboard-link">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px;">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
                Dashboard
            </a>
        </nav>     

        <!-- Right Content Area -->
        <div id="contentArea">

            <!-- Div za tabelu sa kriptovalutama -->
            <div id="cryptoTableContainer" style="display: none;"></div>

            <div id="positionsOverlay">
                <div class="container">
                    <div id="positionsTableContainer"></div>
                </div>
            </div>

            <div id="historyOverlay">
                <div class="container">
                    <div id="historyTableContainer"></div>
                </div>
            </div>

            <div id="ordersOverlay">
                <div class="container">
                    <div id="ordersTableContainer"></div>
                </div>
            </div>

            <!-- Div za TradingView Chart -->
            <div id="cryptoChartContainer" style="display: none;">
                <div id="tradingview-widget-container">
                    <div id="tradingview-chart"></div>
                    <div id="chart-position" class="pos-none"></div>
                </div>

               

                <!-- ====================== DEAL ====================== -->
                <div id="chart-deal" class="tab-content active-content">
                    <div class="deal-tabs">
                        <p class="tab-deal active-tab">Deal</p>
                        <p  class="tab-order">Order</p>
                    </div>
                    <div>
                        <div class="buy-sell">
                            <div>
                                <div class="buy-sell-cells">
                                    <div class="buy-sell-cell" id="cell-sell">
                                        <p class="buy-sell-text">SELL</p>
                                        <p class="buy-sell-price" id="sellPrice">-.0</p>
                                    </div>
                                    <div class="buy-sell-cell" id="cell-buy">
                                        <p class="buy-sell-text">BUY</p>
                                        <p class="buy-sell-price" id="buyPrice">-.0</p>
                                    </div>
                                </div>
                                <div class="buy-sell-size">
                                    <p>Size</p>
                                    <input type="number" id="size-number">
                                </div>
                            </div>
                        </div>

                        <div class="placing">
                            <div class="deal-placing">
                                <p>Margin</p>
                                <p id="margin-text">-</p>
                            </div>
                            <div class="deal-placing">
                                <p>Resulting position</p>
                                <p id="res-pos">-</p>
                            </div>
                            <div class="deal-placing">
                                <p>Stop loss</p>
                                <input type="number" id="stop-deal" placeholder="-">
                            </div>
                            <div class="deal-placing">
                                <p>Take profit</p>
                                <input type="number" id="limit-deal" placeholder="-">
                            </div>
                        </div>

                        <div class="place-deal-container">
                            <button id="place-deal-button">Place deal</button>
                        </div>
                        <div id="place-deal-error" class="place-deal-error"></div>
                    </div>
                </div>


                <!-- ====================== ORDER ====================== -->
                <div id="chart-order" class="tab-content">
                    <div class="deal-tabs">
                        <p class="tab-deal">Deal</p>
                        <p class="tab-order">Order</p>
                    </div>
                    <div>
                        <div class="buy-sell">
                            <div>
                                <div class="buy-sell-cells">
                                    <div class="buy-sell-cell" id="order-cell-sell">
                                        <p class="buy-sell-text">SELL</p>
                                    </div>
                                    <div class="buy-sell-cell" id="order-cell-buy">
                                        <p class="buy-sell-text">BUY</p>
                                    </div>
                                </div>
                                <div class="buy-sell-size">
                                    <p>Size</p>
                                    <input type="number" id="order-size-number">
                                </div>
                                <div class="buy-sell-size">
                                    <p>Order price</p>
                                    <input type="number" id="order-price" placeholder="-">
                                </div>
                            </div>
                        </div>

                        <div class="placing">
                            <div class="deal-placing">
                                <p>Margin</p>
                                <p id="order-margin-text">-</p>
                            </div>
                            <div class="deal-placing">
                                <p>Resulting position</p>
                                <p id="order-res-pos">-</p>
                            </div>
                            <div class="deal-placing">
                                <p>Stop</p>
                                <input type="number" id="stop-order" placeholder="-">
                            </div>
                            <div class="deal-placing">
                                <p>Limit</p>
                                <input type="number" id="limit-order" placeholder="-">
                            </div>
                        </div>

                        <div class="place-deal-container">
                            <button id="place-order-button">Place order</button>
                        </div>
                        <div id="place-deal-error" class="place-deal-error"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/tradingplatform.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="homestyle.css">
</head>

<body class="mobile">
    <?php include 'navbar.php'; ?>
<main>
            <section class="header-types">
                <div>
                    <h1 style="font-weight: 500;">Account Types</h1>
                    <h4>Below you will find information on the account types and respective benefits that you will get for each.</h4>
                    <h4>You won't make a mistake. Take your pick today:</h4>
                </div>
            </section>
        </div>
    <div class="container-types">
            <div class="container-buttons">
                <button onclick="showClassic()" id="classic-button" class="active">Classic</button>
                <button onclick="showPremium()" id="premium-button">Premium</button>
            </div>
        <div class="main-slots" id="classic-main">
            <div class="cards-slots" id="classic-slots">

                <div class="slot-top">
                    <div>
                        <div class="slot-title">Starter</div>
                    </div>
                    <div class="offer-price">$10,000.00</div>
                    <div class="minimum">Minimum Deposit</div>
                </div>
                <div class="slot-bottom">
                    <div class="bottom-padding">
                        <ul>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Leverage up to <span style="font-weight: bolder; font-size: 20px;">1:50</span></div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Trading Bonus: <span style="font-weight: bolder; font-size: 20px;">10%</span> (min $1,000.00)</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Daily News</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Weekly Market Review</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Account Manager</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Monthly Progress Report</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Weekly Live Streaming Trading Webinar</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Monthly 1-on-1 with Market Analyst</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>1 Advisor session per week</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Access to Education Library</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom-disabled"><i class="ri-close-line" style="font-size: 25px; vertical-align: middle; color: #000; margin-right: 5px;"></i>Personal Portfolio Manager</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom-disabled"><i class="ri-close-line" style="font-size: 25px; vertical-align: middle; color: #000; margin-right: 5px;"></i>Monthly Portfolio Planner</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom-disabled"><i class="ri-close-line" style="font-size: 25px; vertical-align: middle; color: #000; margin-right: 5px;"></i>Weekly Market Signals</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom-disabled"><i class="ri-close-line" style="font-size: 25px; vertical-align: middle; color: #000; margin-right: 5px;"></i>In-depth research</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom-disabled"><i class="ri-close-line" style="font-size: 25px; vertical-align: middle; color: #000; margin-right: 5px;"></i>Spreads from</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom-disabled"><i class="ri-close-line" style="font-size: 25px; vertical-align: middle; color: #000; margin-right: 5px;"></i>Swap Discount</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom-disabled"><i class="ri-close-line" style="font-size: 25px; vertical-align: middle; color: #000; margin-right: 5px;"></i>Invites to VIP Events</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom-disabled"><i class="ri-close-line" style="font-size: 25px; vertical-align: middle; color: #000; margin-right: 5px;"></i>AI Powered Arbitrage Trade</div>
                            </li>

                        </ul>
                    </div>
                </div>
            </div> 


            <div class="cards-slots" id="classic-slots">
                <div class="slot-top">
                    <div>
                        <div class="slot-title">Gold</div>
                    </div>
                    <div class="offer-price">$50,000.00</div>
                    <div class="minimum">Minimum Deposit</div>
                </div>
                <div class="slot-bottom">
                    <div class="bottom-padding">
                        <ul>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Leverage up to <span style="font-weight: bolder; font-size: 20px;">1:100</span></div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Trading Bonus: <span style="font-weight: bolder; font-size: 20px;">20%</span> (min $10,000.00)</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Daily News</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Weekly Market Review</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Account Manager</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Monthly Progress Report</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Weekly Live Streaming Trading Webinar</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Weekly 1-on-1 with Market Analyst</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>2 Advisor session per week</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Customized Education Program</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Personal Portfolio Manager</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Monthly Portfolio Planner</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Weekly Market Signals</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>In-depth research</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom-disabled"><i class="ri-close-line" style="font-size: 25px; vertical-align: middle; color: #000; margin-right: 5px;"></i>Spreads from</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom-disabled"><i class="ri-close-line" style="font-size: 25px; vertical-align: middle; color: #000; margin-right: 5px;"></i>Swap Discount</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom-disabled"><i class="ri-close-line" style="font-size: 25px; vertical-align: middle; color: #000; margin-right: 5px;"></i>Invites to VIP Events</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom-disabled"><i class="ri-close-line" style="font-size: 25px; vertical-align: middle; color: #000; margin-right: 5px;"></i>AI Powered Arbitrage Trade</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> 
            <div class="cards-slots" id="classic-slots">
                <div class="slot-top">
                    <div>
                        <div class="slot-title">Platinum</div>
                    </div>
                    <div class="offer-price">$100,000.00</div>
                    <div class="minimum">Minimum Deposit</div>
                </div>
                <div class="slot-bottom">
                    <div class="bottom-padding">
                        <ul>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Leverage up to <span style="font-weight: bolder; font-size: 20px;">1:200</span></div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Trading Bonus: <span style="font-weight: bolder; font-size: 20px;">30%</span> (min. $30,000.00)</span></div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Daily News</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Weekly Market Review</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Account Manager</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Monthly Progress Report</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Weekly Live Streaming Trading Webinar</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Weekly 1-on-1 with Market Analyst</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>3 Advisor session per week</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Customized Education Program</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Personal Portfolio Manager</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Complete Portfolio Plan and Review</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Daily Market Signals</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>In-depth research</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Spreads from: 15 cents</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>50% Swap Discount</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Invites to VIP events</div>
                            </li>
                            <li class="bottom-benefits">
                                <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>1 <span style="color:rgb(217,18,34); font-weight: bolder;">AI Powered</span> Arbitrage Trade</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> 
        </div>


            <div class="main-slots" id="premium-main" style="display: none;">
                <div class="cards-slots" id="premium-slots">
                    
                    <div class="slot-top">
                        <div>
                            <div class="slot-title">Premium Starter</div>
                        </div>
                        <div class="offer-price">$250,000.00</div>
                        <div class="minimum">Minimum Deposit</div>
                    </div>
                    <div class="slot-bottom">
                        <div class="bottom-padding">
                            <ul>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Leverage up to <span style="font-weight: bolder; font-size: 20px;">1:500</span></div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Trading Bonus: <span style="font-weight: bolder; font-size: 20px;">40%</span> (min $100,000.00)</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Daily News</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Weekly Market Review</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Senior Account Manager</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Monthly Progress Report</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Weekly Live Streaming Trading Webinar</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Weekly 1-on-1 with Market Analyst</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Unlimited Advisor sessions per week</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Customized Education Library</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Personal Portfolio Manager</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Portfolio Builder & Portfolio Analyst</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Daily Market Signals</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>In-depth research</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Spreads from 10 cents</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Swap Discount: 50%</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Invites to VIP Events</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>10 <span style="color:rgb(217,18,34); font-weight: bolder;">AI Powered</span> Arbitrage Trades</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>24/7 Account Monitoring</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Account Insurance</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Premium Savings Account</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Tax Report</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom-disabled"><i class="ri-close-line" style="font-size: 25px; vertical-align: middle; color: #000; margin-right: 5px;"></i>Dividend Payout</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom-disabled"><i class="ri-close-line" style="font-size: 25px; vertical-align: middle; color: #000; margin-right: 5px;"></i>Knock-outs Trading</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom-disabled"><i class="ri-close-line" style="font-size: 25px; vertical-align: middle; color: #000; margin-right: 5px;"></i>Out-of-hours Trading</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom-disabled"><i class="ri-close-line" style="font-size: 25px; vertical-align: middle; color: #000; margin-right: 5px;"></i>IPOs</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom-disabled"><i class="ri-close-line" style="font-size: 25px; vertical-align: middle; color: #000; margin-right: 5px;"></i>Wealth Manager</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> 
                <div class="cards-slots" id="premium-slots">
                    <div class="slot-top">
                        <div>
                            <div class="slot-title">Premium Gold</div>
                        </div>
                        <div class="offer-price">$500,000.00</div>
                        <div class="minimum">Minimum Deposit</div>
                    </div>
                    <div class="slot-bottom">
                        <div class="bottom-padding">
                            <ul>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Leverage up to <span style="font-weight: bolder; font-size: 20px;">1:1,000</span></div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Trading Bonus: <span style="font-weight: bolder; font-size: 20px;">50%</span> (min $250,000.00)</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Daily News</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Weekly Market Review</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Senior Account Manager</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Monthly Progress Report</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Weekly Live Streaming Trading Webinar</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Weekly 1-on-1 with Market Analyst</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Unlimited Advisor sessions per week</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Customized Education Program</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Chief Portfolio Manager</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Portfolio Builder & Portfolio Analyst</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Daily Market Signals</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>In-depth research</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Spreads from: 5 cents</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Swap Discount 75%</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Invites to VIP Events</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>30 <span style="color:rgb(217,18,34); font-weight: bolder;">AI Powered</span> Arbitrage Trades</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>24/7 Account Monitoring</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Account Insurance</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Premium Savings Account</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Tax Report</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Dividend Payout</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Knock-outs Trading</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Out-of-hours Trading</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom-disabled"><i class="ri-close-line" style="font-size: 25px; vertical-align: middle; color: #000; margin-right: 5px;"></i>IPOs</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom-disabled"><i class="ri-close-line" style="font-size: 25px; vertical-align: middle; color: #000; margin-right: 5px;"></i>Wealth Manager</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> 
                <div class="cards-slots" id="premium-slots">
                    <div class="slot-top">
                        <div>
                            <div class="slot-title">Premium Platinum</div>
                        </div>
                        <div class="offer-price">$1,000,000.00</div>
                        <div class="minimum">Minimum Deposit</div>
                    </div>
                    <div class="slot-bottom">
                        <div class="bottom-padding">
                            <ul>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i><span style="font-weight: bolder; color: rgb(217,18,34)">Dynamic</span> <strong>Leverage</strong> up to <span style="font-weight: bolder; font-size: 20px;">1:10,000</span></div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Trading Bonus: <span style="font-weight: bolder; font-size: 20px;">100%</span></div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Daily News</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Weekly Market Review</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Senior Account Manager</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Monthly Progress Report</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Weekly Live Streaming Trading Webinar</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Weekly 1-on-1 with Market Analyst</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Unlimited Advisor sessions per week</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Customized Education Program</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Chief Portfolio Manager</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Portfolio Builder & Portfolio Analyst</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Daily Market Signals</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>In-depth research</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Spreads from: 3 cents</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>No Swap</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Invites to VIP Events</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Unlimited <span style="color:rgb(217,18,34); font-weight: bolder;">AI Powered</span> Arbitrage Trade</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>24/7 Account Monitoring</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Account Insurance</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Premium Savings Account</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Tax Report</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Dividend Payout</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Knock-outs Trading</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Out-of-hours Trading</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>IPOs</div>
                                </li>
                                <li class="bottom-benefits">
                                    <div class="item-bottom"><i class="ri-check-line" style="font-size: 25px; vertical-align: middle; color: rgb(217,18,34); margin-right: 5px;"></i>Wealth Manager</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> 
        </div>
    </div>
</main>

    <footer>
        <div id="footer">
            <div class="footer container">
                <div class="footer-menu">
                    <div class="footer-menu_item">
                        <button class="footer-menu_parent" id="menu_company-footer">Company</button>
                        <ul class="footer-menu__children">
                            <li class="footer-menu__child ui-text ui-text_size-s ui-text_lineHeight-200"><a href="aboutus.php" target="">About Us</a></li>
                            <li class="footer-menu__child ui-text ui-text_size-s ui-text_lineHeight-200"><a href="creditscore.php" rel="" target="">Credit Score</a></li>
                            <li class="footer-menu__child ui-text ui-text_size-s ui-text_lineHeight-200"><a href="liquidityprov.php" rel="" target="">Liquidity Providers</a></li>
                            <li class="footer-menu__child ui-text ui-text_size-s ui-text_lineHeight-200"><a href="onlinesecurity.php" rel="" target="">Online Security</a></li>
                        </ul>
                    </div>
                <div class="footer-menu_item">
                    <button class="footer-menu_parent" id="menu_market-footer">Markets</button>
                    <ul class="footer-menu__children">
                        <li class="footer-menu__child ui-text ui-text_size-s ui-text_lineHeight-200"><a href="forex.php" rel="" target="">Forex</a></li>
                        <li class="footer-menu__child ui-text ui-text_size-s ui-text_lineHeight-200"><a href="shares.php" rel="" target="">Shares</a></li>
                        <li class="footer-menu__child ui-text ui-text_size-s ui-text_lineHeight-200"><a href="indices.php"" target="">Indices</a></li>
                        <li class="footer-menu__child ui-text ui-text_size-s ui-text_lineHeight-200"><a href="commodities.php" rel="" target="">Commodities</a></li>
                        <li class="footer-menu__child ui-text ui-text_size-s ui-text_lineHeight-200"><a href="crypto.php" rel="" target="">Cryptocurrencies</a></li>
                </ul>
                </div>
                <div class="footer-menu_item">
                    <button class="footer-menu_parent" id="menu_trading-footer">Trading</button>
                    <ul class="footer-menu__children">
                        <li class="footer-menu__child ui-text ui-text_size-s ui-text_lineHeight-200"><a href="getstarted.php" rel="" target="">Get Started</a></li>
                        <li class="footer-menu__child ui-text ui-text_size-s ui-text_lineHeight-200"><a href="accounttypes.php" rel="" target="">Account Types</a></li>
                        <li class="footer-menu__child ui-text ui-text_size-s ui-text_lineHeight-200"><a href="leverage.php" rel="" target="">Leverage Information</a></li>
                        <li class="footer-menu__child ui-text ui-text_size-s ui-text_lineHeight-200"><a href="leverage.php" rel="" target="">Learn to Trade</a></li>
                    </ul>
                </div>
                <div class="footer-menu_item">
                    <button class="footer-menu_parent" id="menu_docs-footer">Documentation</button>
                    <ul class="footer-menu__children">
                        <li class="footer-menu__child ui-text ui-text_size-s ui-text_lineHeight-200"><a href="legaldocs.php" rel="" target="">Legal Docs</a></li>
                        <li class="footer-menu__child ui-text ui-text_size-s ui-text_lineHeight-200"><a href="legaldocs.php" rel="" target="">Terms & Conditions</a></li>
                        <li class="footer-menu__child ui-text ui-text_size-s ui-text_lineHeight-200"><a href="legaldocs.php" rel="" target="">Privacy Policy</a></li>
                        <li class="footer-menu__child ui-text ui-text_size-s ui-text_lineHeight-200"><a href="legaldocs.php" rel="" target="">Risk Disclosure</a></li>
                        <li class="footer-menu__child ui-text ui-text_size-s ui-text_lineHeight-200"><a href="legaldocs.php" rel="" target="">Cost & Fee Structure</a></li>
                    </ul>
                </div>
                <div class="footer-menu_item">
                    <button class="footer-menu_parent" id="menu_contact-footer">Contact Us</button>
                    <ul class="footer-menu__children">
                        <li class="footer-menu__child ui-text ui-text_size-s ui-text_lineHeight-200"><a href="" rel="" target="">Clients: +447450098234</a></li>
                        <li class="footer-menu__child ui-text ui-text_size-s ui-text_lineHeight-200"><a href="mailto:support@alpinemarkets.com" rel="" target="">E-mail: support@alpinemarkets.com</a></li>
                    </ul>
                </div>
            </div>
    
     </footer>


<script>
window.addEventListener('resize', function(){
    addRequiredClass();
})


function addRequiredClass() {
    if (window.innerWidth < 860) {
        document.body.classList.add('mobile')
    } else {
        document.body.classList.remove('mobile') 
    }
}

window.onload = addRequiredClass

let hamburger = document.querySelector('.hamburger')
let mobileNav = document.querySelector('.nav-list')

let bars = document.querySelectorAll('.hamburger span')

let isActive = false

hamburger.addEventListener('click', function() {
    mobileNav.classList.toggle('open')
    if(!isActive) {
        bars[0].style.transform = 'rotate(45deg)'
        bars[1].style.opacity = '0'
        bars[2].style.transform = 'rotate(-45deg)'
        isActive = true
    } else {
        bars[0].style.transform = 'rotate(0deg)'
        bars[1].style.opacity = '1'
        bars[2].style.transform = 'rotate(0deg)'
        isActive = false
    }
    

})

// Get references to the buttons and card slots containers
const classicButton = document.getElementById('classic-button');
const premiumButton = document.getElementById('premium-button');
const vipButton = document.getElementById('vip-button');
const classicMain = document.getElementById('classic-main');
const premiumMain = document.getElementById('premium-main');
const vipMain = document.getElementById('vip-main');


function showClassic() {
        document.getElementById('classic-main').style.display = 'flex';
        document.getElementById('premium-main').style.display = 'none';
        document.getElementById("vip-main").style.display = "none";
    }

    function showPremium() {
        document.getElementById('classic-main').style.display = 'none';
        document.getElementById('premium-main').style.display = 'flex';
        document.getElementById("vip-main").style.display = "none";
    }


function showVIP() {
    document.getElementById("classic-main").style.display = "none";
    document.getElementById("premium-main").style.display = "none";
    document.getElementById("vip-main").style.display = "flex";
}

document.addEventListener('DOMContentLoaded', function() {
    var buttons = document.querySelectorAll('.container-buttons button');

    buttons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            buttons.forEach(function(btn) {
                btn.classList.remove('active');
            });
            // Add active class to the clicked button
            button.classList.add('active');
        });
    });
});

    </script>
</body>

</html>
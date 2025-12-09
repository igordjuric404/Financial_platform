<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
    <title>Alpine Markets</title>
    <link rel="stylesheet" href="homestyle.css">
</head>

<body class="mobile">
    <?php include 'navbar.php'; ?>
    <main>
        <section class="header container links" id="leverage-main">
            <div>
                <h1> <div><img src="images/rocket-svgrepo-com.svg" style="width: 100px; margin-bottom: 20px;";></div>Leverage Information</h1>
                <h4>Dynamic Leverage. You choose how and when to apply leverage.<br>With VIP status you can get up to <span class="ai-powered" style="font-size: 25px;"><strong>1:10,000</strong></span> leverage on ceratin assets.</h4>
                <h4><strong>Retail Clients</strong><br>Below you will find information regarding the levarage offered for Retail clients.</h4>
            </div>
            <div class="totals">
                            <div class="boxes">
                                <div class="small-box">
                                    <p class="top-info">1:200</p>
                                    <p class="bottom-info">Forex</p>
                                </div>
                                <div class="small-box">
                                    <p class="top-info">1:200</p>
                                    <p class="bottom-info">Commodities</p>
                                </div>
                                <div class="small-box">
                                    <p class="top-info">1:200</p>
                                    <p class="bottom-info">Major Indices</p>
                                </div>
                                <div class="small-box">
                                    <p class="top-info">1:100</p>
                                    <p class="bottom-info">Minor Indices</p>
                                </div>
                                <div class="small-box">
                                    <p class="top-info">1:50</p>
                                    <p class="bottom-info">Shares</p>
                                </div>
                                <div class="small-box">
                                    <p class="top-info">1:20</p>
                                    <p class="bottom-info">Crypto</p>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="header container links" id="margin-req">
                        <div>
                            <h1><span class="ai-powered">Dynamic Margin</span> Requirements</h1>
                            <h4>We use dynamic leverage model for the assets on our platform<br>which automatically adapts to the clients trading positions.<br>As the volume per Instrument of a client increases,<br> the maximum leverage offered adapts to increase overall safety.</h4>
                        </div>
                        <div id="leverage-info">
                            <p>During periods of heightened market volatility, higher margin amounts are necessary to initiate new trades. This measure aims to minimize traders' exposure to price instability during significant economic events.</p>
                            <p>Therefore, new orders opened within 15 minutes before and 5 minutes after high-impact economic news releases are subject to these elevated margin requirements. Once this critical period ends, typically 5 minutes after the news release, the HMR (Higher Margin requirements) is lifted, and margin requirements are reevaluated based on the trading account's equity and leverage.</p>
                            <p>Higher Margin Requirements:</p>
                            <p class="margin-info"><i class="ri-arrow-right-s-fill" style="color: rgb(217,18,34);"></i>Forex: 1:100</p>
                            <p class="margin-info"><i class="ri-arrow-right-s-fill" style="color: rgb(217,18,34);"></i>Commodities: 1:100</p>
                            <p class="margin-info"><i class="ri-arrow-right-s-fill" style="color: rgb(217,18,34);"></i>Indices: 1:50</p>
                            <p class="margin-info"><i class="ri-arrow-right-s-fill" style="color: rgb(217,18,34);"></i>Shares: 1:25</p>
                            <p class="margin-info"><i class="ri-arrow-right-s-fill" style="color: rgb(217,18,34);"></i>Crypto: 1:10</p>
                            <P></P>
                            <p>The duration of higher margin requirements may be extended based on risk management decisions.</p>
                        </div>
                    </section>            
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
                        <li class="footer-menu__child ui-text ui-text_size-s ui-text_lineHeight-200"><a href="indices.php" target="">Indices</a></li>
                        <li class="footer-menu__child ui-text ui-text_size-s ui-text_lineHeight-200"><a href="commodities.php" rel="" target="">Commodities</a></li>
                        <li class="footer-menu__child ui-text ui-text_size-s ui-text_lineHeight-200"><a href="crypto.php" rel="" target="">Cryptocurrencies</a></li>
                </ul>
                </div>
                <div class="footer-menu_item">
                    <button class="footer-menu_parent" id="menu_trading-footer">Trading</button>
                    <ul class="footer-menu__children">
                        <li class="footer-menu__child ui-text ui-text_size-s ui-text_lineHeight-200"><a href="accounttypes.php" rel="" target="">Account Types</a></li>
                        <li class="footer-menu__child ui-text ui-text_size-s ui-text_lineHeight-200"><a href="leverage.php" rel="" target="">Leverage Information</a></li>
                        <li class="footer-menu__child ui-text ui-text_size-s ui-text_lineHeight-200"><a href="blocktrade.php" rel="" target="">Block Trade</a></li>
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
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
    <title>Responsive navbar</title>
    <link rel="stylesheet" href="homestyle.css">
</head>

<body class="mobile">
    <?php include 'navbar.php'; ?>
    <main>
        <section class="header container links">
            <div>
                <div><img src="images/speedometer-svgrepo-com.svg" style="width: 100px; margin-bottom: 40px;";></div>
                <h1>What is Credit Score?</h1>
                <h4>A credit score is an assessment of the creditworthiness of an individual or a business in order to judge how secure the concerning party is.</h4>
            </div>
        </section>
        <section class="header container" id="row-symbol">
            <div class="container" id="container-symbol">
                <div class="row">
                    <div class="pricing">
                        <div class="row align-items-center">
                            <div class="pricing-pic">
                                    <div><i class="ri-code-box-line" style="color: rgb(217, 18, 34)"></i></div>
                            </div>
                            <div class="pricing-description">
                                    <h5 class="mt-15">Unbiased overview</h5>
                                    <p>It is an algorithm that estimates the credit risk of a prospective debtor (e.g. ability to pay on time)</p>
                            </div>
                        </div>
                    </div>
                    <div class="tech">
                        <div class="row align-items-center">
                            <div class="tech-pic">
                                <div><i class="ri-database-line"></i></div>
                            </div>
                            <div class="tech-description">
                                <h5 class="mt-15">Combines Key Data</h5>
                                <p>E.g. trade payment information, public information, industry sector analysis, debts, borrowing and other key performance indicators</p>
                            </div>
                        </div>
                    </div>
                    <div class="assets">
                        <div class="row align-items-center">
                            <div class="assets-pic">
                                <div><i class="ri-line-chart-line" style="color: rgb(217, 18, 34)"></i></div>
                            </div>
                            <div class="assets-description">
                                <h5 class="mt-15">Make correct decisions</h5>
                                <p>Credit score can be used to predict the likelihood of a business failing</p>
                            </div>
                        </div>
                    </div>
                    <div class="security">
                        <div class="row align-items-center">
                            <div class="security-pic">
                                <div><i class="ri-donut-chart-fill"></i></div>
                            </div>
                            <div class="security-description">
                                <h5 class="mt-15">It rates businesses on a scale from 0 to 100</h5>
                                <p>A high score indicates a lower risk of default or bankruptcy. A low score indicates a higher risk of default or bankruptcy</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="header container credit-score">
            <div class="container" id="container-laptop">
                <div class="row justify-content-center">
                    <div class="platform-text">
                        <h2 class="mb-3"><span class="ai-powered">Credit Score</span><br>How do we Score?</h2>                   
                    </div>
                    <div class="platform-image">
                        <img src="Images/US.png" loading="lazy">
                    </div>
                </div>
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


    </script>
</body>

</html>
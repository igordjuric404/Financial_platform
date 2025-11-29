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
        <div class="container-home">
            <section class="header container" id="home-link">
                <div id="main-text">
                    <h1>Trade with Professionals. Let us show you how</h1>
                    <h4>Cutting-edge platform. Competitve rates. Make the choice now.</h4>
                    <div id="main-button">
                        <a href="register.php">
                        <button class="btn">Open Account</button></a>
                    </div>
                </div>
            </section>
        </div>
        <section class="header container" id="row-symbol">
            <div class="container" id="container-symbol">
                <div class="row">
                    <div class="pricing">
                        <div class="row align-items-center">
                            <div class="pricing-pic">
                                    <div><i class="ri-currency-line"></i></div>
                            </div>
                            <div class="pricing-description">
                                    <h5 class="mt-15">Competitve Pricing</h5>
                                    <p>Competitive spreads, low swaps. Yield enhancment schemes. Free access to exclusive tool.</p>
                            </div>
                        </div>
                    </div>
                    <div class="tech">
                        <div class="row align-items-center">
                            <div class="tech-pic">
                                <div><i class="ri-code-line"></i></div>
                            </div>
                            <div class="tech-description">
                                <h5 class="mt-15">AI Implementation</h5>
                                <p>Unique implementation of AI systems, that allow automation of trading processes.</p>
                            </div>
                        </div>
                    </div>
                    <div class="assets">
                        <div class="row align-items-center">
                            <div class="assets-pic">
                                <div><i class="ri-btc-line"></i></div>
                            </div>
                            <div class="assets-description">
                                <h5 class="mt-15">1,000+ assets</h5>
                                <p>From currencies, worldwide shares, metals, energies, Bitcoin.</p>
                                <p>We have it all.</p>
                            </div>
                        </div>
                    </div>
                    <div class="security">
                        <div class="row align-items-center">
                            <div class="security-pic">
                                <div><i class="ri-lock-password-line"></i></div>
                            </div>
                            <div class="security-description">
                                <h5 class="mt-15">Protection &amp; Safety</h5>
                                <p>More than $4 billion in AUM, automated risk controls, all assets marked to market daily. </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="header container">
            <div class="container" id="container-laptop">
                <div class="row justify-content-center">
                    <div class="platform-image">
                        <img src="Images/laptoptradingview.png" loading="lazy">
                    </div>
                    <div class="platform-text">
                        <h2 class="mb-3"><span class="ai-powered">AI Powered</span> Trading Platform<span class="your-success"><br></span>For your Success</h2>
                            <div class="filler">
                                <p>Powerful platform for every investor from beginner to pro on mobile, web and desktop. All markets available:</p>
                                </div>
                            <div class="filler">
                                <p>Forex market opportunities get new dimension when coupled with AI. Scalp imperceptable movements now.</p>
                                <p class="btn-markets"><a href="forex.php" target="_self" class="link-chevron-circle-right">Forex  <i class="ri-arrow-right-s-line"></i></a></p>
                            </div>
                            <div class="filler">
                                <p>Thousands of comapnies from the US, UK, EU and many other markets. Our platform provides you real-time data 24/7.</p>
                                <p class="btn-markets"><a href="shares.php" target="_self" class="link-chevron-circle-right">Shares &amp; Indices  <i class="ri-arrow-right-s-line"></i></a></p>
                            </div>
                            <div class="filler">
                                <p>Combine AI with Gold, Silver, Platinum, Crude Oil, Natural Gas and other commodities for new opportunities.</p>
                                <p class="btn-markets"><a href="/en/trading/ordertypes.php" target="_self" class="link-chevron-circle-right">Metals &amp; Energies  <i class="ri-arrow-right-s-line"></i></a></p>
                            </div>
                            <div class="filler">
                                <p>Take advantage of dynamic movements of Bitcoin, Ethereum, Solana, Doge and many more.</p>
                                <p class="btn-markets"><a href="crypto.php" target="_self" class="link-chevron-circle-right">Crypto <i class="ri-arrow-right-s-line"></i></a></p>
                            </div>  
                              
                    </div>
                </div>
            </div>
        </section>
        <section class="header container">
            <div class="container" id="container-vault">
                <div class="this align-items-center">
                    <div class="confidence-text">
                        <h2><span class="confidence-title">Confidence</span> is in <span class="numbers-title">Numbers</span></h2>
                        <p class="text-vault">When placing your money with a broker, you need to make sure your broker is stable and secure. Our strong capital position, conservative balance sheet and automated risk controls are designed to protect Company and our clients from large trading losses.</p>
                        <div class="totals">
                            <div class="boxes">
                                <div class="small-box">
                                    <p class="top-info">$4.1B</p>
                                    <p class="bottom-info">Equity Capital</p>
                                </div>
                                <div class="small-box">
                                    <p class="top-info">3.15M</p>
                                    <p class="bottom-info">Client Accounts</p>
                                </div>
                                <div class="small-box">
                                    <p class="top-info">$1.946M</p>
                                    <p class="bottom-info">Daily Avg Trades Revenue</p>
                                </div>
                                <div class="small-box">
                                    <p class="top-info">500+</p>
                                    <p class="bottom-info"># of Employees</p>
                                </div>
                                <div class="small-box">
                                    <p class="top-info">14</p>
                                    <p class="bottom-info">Years in Business</p>
                                </div>
                                <div class="small-box">
                                    <p class="top-info">11</p>
                                    <p class="bottom-info">Liquidity Providers</p>
                                </div>
                            </div>
                        </div>
                        <a href="onlinesecurity.php" class="btn-vault" target="_self" hreflang="en-US">Online Security</a>
                    </div>
                    <div class="confidence-image">
                        <img loading="lazy" src="Images/vault2img.png">
                    </div>
                </div>
            </div>
        </section>
        <section class="header container" id="providers_header">
            <div class="container" id="container_providers">
                <div class="register-steps">
                    <div class="col">
                        <h2 class="text-center">Our Liquidity Providers</h2>
                    </div>
                </div>
                <div class="providers-main">
                    <div class="providers">
                        <img loading="lazy" src="Images/citi.png"></img>
                    </div>
                    <div class="providers">
                        <img loading="lazy" src="Images/jpm2.png"></img>
                    </div>
                    <div class="providers">
                        <img loading="lazy" src="Images/gs3.png"> </img>
                    </div>
                    <div class="providers">
                        <img loading="lazy" src="Images/nomura2.png">
                    </div>
                    <div class="providers">
                        <img loading="lazy" src="Images/ubs.png"></img>
                    </div>
                   <div class="providers">
                        <img idloading="lazy" src="Images/julius.png"></img>
                    </div>
                </div>
                        </div>
        </section>
        <section id="three-steps" class="header container"  loading="lazy">
            <div class="container">
                <div class="register-steps">
                    <div class="steps">
                        <h5>Step 1</h5>
                        <h3>Complete the Application </h3>
                        <p>It only takes 2 minutes</p>
                    </div>
                    <div class="steps">
                        <h5>Step 2</h5>
                        <h3>Fund Your Account</h3>
                        <p>Connect your bank or your crypto wallet</p>
                    </div>
                    <div class="steps">
                        <h5>Step 3</h5>
                        <h3>Start Trading</h3>
                        <p>Take your investing to the next level</p>
                    </div>
                </div>
                <div class="register-step">
                    <div class="col text-center">
                        <a href="register.php">
                            <button class="btn">Open Account</button> </a>
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
                        <li class="footer-menu__child ui-text ui-text_size-s ui-text_lineHeight-200"><a href="indices.php"" target="">Indices</a></li>
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

if (hamburger) hamburger.addEventListener('click', function() {
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
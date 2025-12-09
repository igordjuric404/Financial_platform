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
        <section class="header container links">
            <div>
                <div><img src="images/agreement-contract-a4-paper-svgrepo-com.svg" style="width: 100px; margin-bottom: 40px;";></div>
                <h1>Legal Documentation</h1>
                <h4>For your own benefit and protection please read the documents below and any other information made available to you via this website prior to opening an account or placing an order.</h4>
                <h4>Our legal documents are provided in the company's official language of English to ensure clarity and transparency. If you need any clarifications, our support team are ready to assist you.</h4>
            </div>
        </section>
            <div class="conatainer types" id="legal-links">
                <ul class="docs-legal">
                    <li style="padding-bottom: 30px;"><a href="aboutus.php" target="_blank"><img src="images/pdf-svgrepo-com.svg" style="width: 30px;vertical-align: middle; margin-right: 20px;">Terms and Conditions</a></li>
                    <li style="padding-bottom: 30px;"><a href="aboutus.php" target="_blank"><img src="images/pdf-svgrepo-com.svg" style="width: 30px;vertical-align: middle; margin-right: 20px;">Privacy Policy</a></li>
                    <li style="padding-bottom: 30px;"><a href="aboutus.php" target="_blank"><img src="images/pdf-svgrepo-com.svg" style="width: 30px;vertical-align: middle; margin-right: 20px;">Risk Disclosure</a></li>
                    <li><a href="aboutus.php" target="_blank"><img src="images/pdf-svgrepo-com.svg" style="width: 30px;vertical-align: middle; margin-right: 20px;">Cost and Fee Structure</a></li>
                </ul>
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
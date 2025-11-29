<?php
session_start(); // Ako već nije startovana sesija, startuj je
?>

<nav>
    <div class="container nav-wrapper">
        <div class="logo">
            <a href="index.php">
                <img src="images/logo.png" alt="Financial Asset Tracker Logo" class="main-logo">
            </a>
        </div>

        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <ul class="nav-list">
            <li>
                <a href="#">Company</a>
                <ul class="dropdown-list">
                    <li><a href="aboutus.php">About Us</a></li>
                    <li><a href="creditscore.php">Credit Score</a></li>
                    <li><a href="liquidityprov.php">Liquidity Providers</a></li>
                    <li><a href="onlinesecurity.php">Online Security</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Markets</a>
                <ul class="dropdown-list">
                    <li><a href="forex.php">Forex</a></li>
                    <li><a href="shares.php">Shares</a></li>
                    <li><a href="indices.php">Indices</a></li>
                    <li><a href="commodities.php">Commodities</a></li>
                    <li><a href="crypto.php">Cryptocurrencies</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Trading</a>
                <ul class="dropdown-list">
                    <li><a href="accounttypes.php">Account Types</a></li>
                    <li><a href="leverage.php">Leverage Information</a></li>
                    <li><a href="blocktrade.php">Block Trade</a></li>
                </ul>
            </li>
            <li class="become-partner">
                <a href="partner.php" class="nav__link become-partner">Partner with Us</a>
            </li>

            <?php if (isset($_SESSION['user']) && !empty($_SESSION['user'])): ?>
                <!-- Ako je korisnik ulogovan -->
                <li>
                    <a href="clientportal.php">
                        <button class="btn">Client Portal</button>
                    </a>
                </li>
            <?php else: ?>
                <!-- Ako korisnik nije ulogovan -->
                <li>
                    <a href="register.php">
                        <button class="btn">Open Account</button>
                    </a>
                </li>
                <li>
                    <a href="login.php">
                        <button class="btn login-btn">Login</button>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

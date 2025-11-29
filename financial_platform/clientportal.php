<?php
session_start();  // Pokrećemo sesiju na početku fajla

// Proveravamo da li je korisnik ulogovan
if (!isset($_SESSION['user']) || !is_array($_SESSION['user'])) {
    // Ako nije ulogovan ili sesija nije niz, preusmeravamo ga na login stranicu
    header("Location: login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags, title, and other head content -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="test.css"> <!-- Link to your CSS file -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
    <!-- Header with logo and navigation menu -->

<body class="mobile">
    <nav>
        <div class="top-header">
        <div class="logo">
            <a href="index.php"><img src="images/logo.png" alt="Financial Asset Tracker Logo" class="main-logo"></a>
        </div>
        <div class="header-right">

            <div class="dropdown">
                <button onclick="toggleSettingsDropdown()" class="dropbtn"><img src="Images/settings-svgrepo-com.svg" style="width: 25px; vertical-align: middle; margin-right: 10px;"><span class="sr-only">Settings</span></button>
                <div id="settingsDropdown" class="dropdown-content">
                    <a href="passwords.php">Password</a>

                </div>
            </div>
            <div class="dropdown">
                <button onclick="toggleUserProfileDropdown()" class="dropbtn"><img src="Images/profile-user-account-svgrepo-com.svg" style="width: 25px; vertical-align: middle; margin-right: 10px;"><span class="sr-only">Profile</span></button>
                <div id="userProfileDropdown" class="dropdown-content">
                    <a href="personaldetails.php">Personal Details</a>
                    
                    <a href="php/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
    </nav>
     <div class="container nav-wrapper">
            <div class="menu-container">
                <div class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="menu-text">Menu</div>
            </div>
            <ul class="nav-list">
                <li>
                    <a href="clientportal.php" class="active">Dashboard</a>
                </li>
                <li>
                    <a href="deposit.php">Deposit</a>
                </li>
                <li>
                    <a href="withdraw.php">Withdrawal</a>
                </li>
                <li class="become-partner"><a href="tradingplatform.php" class="nav__link become-partner">Open Trading Platform</a></li>
            </ul>
        </div>
    
    <div class="container-main" id="dashboard">
        <div class="box">
            <p>Hello <?php echo $_SESSION['user']['firstName'] . ' ' . $_SESSION['user']['lastName']; ?>!</p>        </div>
        <!-- <div class="box">
            <img src="images/plus-svgrepo-com.svg" style="width: 25px; margin-left: 10px; vertical-align: middle;" alt="Plus Icon">
            <p1 style="font-size: 15px; font-weight: 400;">Add an Account</p1>
        </div> -->

        <!-- HTML -->
        <table class="user-table">
            <thead>
                <tr>
                    <th>CFDs</th>
                    <th>Funds</th>
                    <th>Margin</th>
                    <th>Available</th>
                    <th>Profit/Loss</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>#3355667</td>
                    <td id="user-balance" data-balance="<?php echo $_SESSION['user']['balance'] ?>">
                        $<?php echo $_SESSION['user']['balance'] ?>
                    </td>
                    <td id="user-margin">$0.00</td>
                    <td id="user-free">$0.00</td>
                    <td id="user-pl">$0.00</td>
                </tr>
                <tr>
                    <td colspan="5"><a href="tradingplatform.php" class="platform-btn">Open Platform</a></td>
                </tr>
            </tbody>
        </table>
        <div id="chart">
            <canvas id="historyChart" width="400" height="200"></canvas>
        </div>
    </div>

    <script src="clientportal.js"></script> <!-- Link to your JavaScript file -->
    <script src="clientportal-new.js"></script>
</body>
</html>

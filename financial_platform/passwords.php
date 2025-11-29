<?php
session_start();

// Proveravamo da li je korisnik ulogovan
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user']['userId'];  // Preuzimanje user_id iz sesije
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags, title, and other head content -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="test.css"> <!-- Link to your CSS file -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                    <a href="clientportal.php">Dashboard</a>
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
    </nav>

        <!-- Main content -->
        <main>
            <div class="container-main" id="header-pages">
                <div class="main-form" id="header-main">
                <h1>Change Password</h1>
                <form id="password-form">
                    <div class="form-group">
                        <label for="current-password"></label>
                        <input type="password" id="password" name="password" placeholder="Current Password" required>
                    </div>
                    <div class="form-group">
                        <label for="password"></label>
                        <div class="password-container">
                            <input type="password" id="new-password" name="new-password" placeholder="New Password" required>
                            <span class="toggle-password" onclick="togglePasswordVisibility('new-password')"></span>
                        </div>
                        </div>
                    <div class="form-group">
                        <label for="confirm-password"></label>
                        <div class="password-container">
                        <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password" required>
                        <span class="toggle-password" onclick="togglePasswordVisibility('confirm-password')"></span>
                    </div>
                    </div>
                </form>
                <div id="password-errors" style="color: red; margin-bottom: 10px;"></div>
                <div class="submit-buttons">
                    <button type="submit" class="buttons">Change</button>
                </div>
            </div>
        </div>
    
     </main>

    <script src="clientportal.js"></script> <!-- Link to your JavaScript file -->
</body>
</html>
<?php

session_start();
if(isset($_SESSION['user'])){
    header('Location: clientportal.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <!-- Header with logo and navigation menu -->
        <div class="logo">
            <a href="index.php"><img src="images/logo.png" alt="Financial Asset Tracker Logo" class="main-logo"></a>
        </div>
        <div class="register-button">
            <a href="register.php">Register Now</a>
        </div>
    </header>
    <main>
        <div class="content">
            <h1>Login to Your Account</h1>
            <form id="login-form">
                <div class="form-group">
                <input type="email" id="email" name="email" placeholder="Enter your E-mail" required>
                </div>
                <div class="form-group">
                    <input type="password" id="password" name="password" placeholder="Enter your Password" required>
                    <!-- <div class="form-group">
                        <p class="forgot-password"><a href="resetpassmail.php">Forgot Password?</a></p>
                    </div> -->
                </div>
                <!-- <div class="form-group">
                    <p class="forgot-password"><a href="resetpassmail.php" class="forgot-pass">Forgot Password?</a></p>
                </div> -->
            </form>
            <div id="login-error" style="color:red; margin-bottom:10px; display:none;"></div>
            <div class="mainlog-button" id="login-button">
                <a>Login</a>
            </div>
                <div class="register-now">
                    <p class="no-acc">Don't have an account? <a href="register.php" class="reg-now">Register Now</a></p></div>
    </main>
    <footer>
        <!-- Footer content -->
    </footer>
    <script src="js/main.js"></script>
    <script src="scripts.js"></script> <!-- Link to your JavaScript file for any interactive elements -->
</body>
</html>
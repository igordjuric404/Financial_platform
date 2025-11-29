<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file for styling -->
</head>
<body>
    <header>
        <!-- Header with logo and navigation menu -->
        <div class="logo">
            <a href="index.php"><img src="images/logo.png" alt="Financial Asset Tracker Logo" class="main-logo"></a>
        </div>
        <div class="login-button">
            <a href="login.php">Log In</a>
        </div>
    </header>
    <main>
        <div class="content">
            <h1>Forgot Your Password?</h1>
            <p>Enter your email address below, and we'll send you a link to reset your password.</p>
            <form action="send-reset-link.php" method="post">
                <div class="form-group">
                    <label for="email"></label>
                    <input type="email" id="email" name="email" placeholder="E-mail">
                </div>
            </form>
            <div class="resetmail-button">
                <a href="resetpass.php">Reset Password</a>
            </div>
        </div>
    </main>
    <footer>
        <!-- Footer content -->
    </footer>
    <script src="scripts.js"></script> <!-- Link to your JavaScript file for any interactive elements -->
</body>
</html>
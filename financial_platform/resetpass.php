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
            <h1>Reset Your Password</h1>
            <form action="reset-password.php" method="post">
                <div class="form-group">
                    <label for="password"></label>
                    <input type="password" id="password" name="password" placeholder="New Password">
                </div>
                <div class="form-group">
                    <label for="confirm-password"></label>
                    <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm Password">
                </div>
            </form>
                <input type="hidden" name="token" value="token_value_here"> <!-- Replace with actual token value -->
                <button class="reset-button" type="submit">Reset Password</button>
        </div>
    </main>
    <footer>
        <!-- Footer content -->
    </footer>
    <script src="scripts.js"></script> <!-- Link to your JavaScript file for any interactive elements -->
</body>
</html>
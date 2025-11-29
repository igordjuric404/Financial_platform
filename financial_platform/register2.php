<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Details Page</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file for styling -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <!-- Header with logo and navigation menu -->
        <div class="logo">
            <a href="index.php"><img src="images/logo.png" alt="Financial Asset Tracker Logo" class="main-logo"></a>
        </div>
    </header>
    <main>
        <div class="content">
        <h1>Personal Details</h1>
        <form id="personal-details-form">
            <div class="name-group">
            <div class="form-group">
                <label for="first-name"></label>
                <input type="text" id="first-name" name="first-name" placeholder="First Name" required>
            </div>
            <div class="form-group">
                <label for="last-name"></label>
                <input type="text" id="last-name" name="last-name" placeholder="Last Name" required>
            </div>
            </div>
            <div class="form-group">
                <input type="text" id="date-of-birth" name="date-of-birth" placeholder="DD/MM/YYYY" maxlength="10" required
                       oninput="autoFormatDate(this)" onblur="validateDate(this)">
            </div>
            <div class="form-group">
                <label for="phone"></label>
                <input type="phone" id="phone" name="phone" placeholder="Your mobile number" required>
            </div>
        </form>
        <div class="save-button" id="save-btn">
            <a href="clientportal.php">Save and Continue</a>
        </div>
        </div>
    </main>

    <footer>
        <!-- Footer content -->
    </footer>
    <script src="js/main.js"></script>
    <script src="scripts.js"></script> <!-- Link to your JavaScript file for any interactive elements -->
</body>
</html>
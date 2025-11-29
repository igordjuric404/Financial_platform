<?php

session_start();

if(!isset($_SESSION['user'])){
    header('Location: login.php');
    exit;
}

error_log(print_r($_SESSION['user'], true));

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
            <div class="container-main" id="details">
                <div class="main-form" id="personal">
                    <h1>Client Profile</h1>
                    <form id="personaldetails-form">
                        <div class="form-group special-form-group">
                            <label for="first-name"></label>
                            <input type="text" id="first-name" name="first-name" placeholder="First Name" required readonly>
                        </div>
                        <div class="form-group special-form-group">
                            <label for="last-name"></label>
                            <input type="text" id="last-name" name="last-name" placeholder="Last Name" required readonly>
                        </div>
                        <div class="form-group special-form-group">
                            <label for="date-of-birth"></label>
                            <input type="text" id="date-of-birth" name="date-of-birth" placeholder="Date of Birth" required readonly>
                        </div>
                        
                        <div class="form-group special-form-group">
                            <label for="street-name"></label>
                            <input type="text" id="street-name" name="street-name" placeholder="Street Name & Number,Building">
                        </div>
                        <div class="form-group special-form-group">
                            <label for="postal-code"></label>
                            <input type="text" id="postal-code" name="postal-code" placeholder="Postal/ZIP code">
                        </div>
                        <div class="form-group special-form-group">
                            <label for="city-town"></label>
                            <input type="text" id="city-town" name="city-town" placeholder="City/Town">
                        </div>
                        <div class="form-group special-form-group">
                            <label for="country-label"></label>
                            <input type="text" id="country-label" name="country-label" placeholder="Country">
                        </div>
                        <!-- Add other client profile fields here -->

                    </form>
                    </div>
                    <div class="main-form" id="personal">
                    <h1>Contact Information</h1>
                    <form id="contact-form">
                        <div class="form-group special-form-group-contact">
                            <label for="email"></label>
                            <input type="email" id="email" name="email" placeholder="Your E-mail" required readonly>
                        </div>
                        <div class="form-group special-form-group-contact">
                            <label for="phone"></label>
                            <input type="text" id="phone" name="phone" placeholder="Your mobile number" required readonly>
                        </div>
                        <div class="form-group special-form-group-contact">
                            <label for="transfer-method">Referral Code</label>
                    <input type="text" id="transfer-method" value="" readonly>
                        </div>
                    </form>
                </div>
            </div>

            <div class="button-container">
                <button type="submit" id="personal-button">Submit</button>
            </div>
    </main>

    <script src="js/main.js"></script>
    <script src="clientportal.js"></script> 
    <script>
    window.onload = function() {
    // Proslijedi PHP podatke u JavaScript
    var userData = <?php echo json_encode($_SESSION['user']); ?>;

    // Postavi vrednosti u formu
    document.getElementById("first-name").value = userData.firstName;
    document.getElementById("last-name").value = userData.lastName;
    document.getElementById("date-of-birth").value = userData.dateOfBirth;
    document.getElementById("phone").value = userData.phone;
    document.getElementById("email").value = userData.email;
    document.getElementById("country-label").value = userData.country;
    if(userData.address != 'N/A'){
        document.getElementById("street-name").value = userData.address;
    }
    if(userData.zipCode != 'N/A'){
        document.getElementById("postal-code").value = userData.zipCode;
    }
    if(userData.city != 'N/A'){
        document.getElementById("city-town").value = userData.city;
    }

    // Ako su vrednosti prazne, prikazati grešku (opcionalno)
    if (!userData.firstName.trim() || !userData.lastName.trim() || !userData.dateOfBirth.trim() || !userData.phone.trim()) {
        alert("Error: Some session values are missing.");
    }
};

</script>
</body>
</html>
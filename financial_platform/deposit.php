<?php
session_start();

// Proveravamo da li je korisnik ulogovan
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user']['userId'];  // Preuzimanje user_id iz sesije

include('php/connection.php');  // Uključi konekciju sa bazom

// Upit za uzimanje poslednjih depozita (transakcija) korisnika
$query = "SELECT transaction_type, amount, created_at FROM balance_transactions WHERE user_id = :user_id AND transaction_type = 'deposit' ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $userId);
$stmt->execute();
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Portal - Deposit</title>
    <link rel="stylesheet" href="test.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
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
                <li><a href="clientportal.php">Dashboard</a></li>
                <li><a href="deposit.php" class="active">Deposit</a></li>
                <li><a href="withdraw.php">Withdrawal</a></li>
                <li class="become-partner"><a href="tradingplatform.php" class="nav__link become-partner">Open Trading Platform</a></li>
            </ul>
        </div>
    </nav>

    <!-- Main content -->
    <main>
        <div class="container-main">
            <div class="main-form">
                <div class="form-group">
                    <h5>Deposit Funds</h5>
                    <label for="transfer-method">Transfer Method</label>
                    <input type="text" id="transfer-method" value="Crypto" readonly>
                </div>
                <div class="field">
                    <label for="coin">Coin</label>
                    <select id="coin">
                        <option value="0">Choose Coin</option>
                        <option value="BTC">BTC</option>
                        <option value="ETH">ETH</option>
                        <option value="USDT">USDT (ERC-20)</option>
                    </select>
                </div>
                <div class="field">
                    <label for="wallet-address">Amount</label>
                    <input type="number" id="wallet-address" />
                </div>
                <div class="field">
                    <button id="confirm-deposit" onclick="">Deposit Request</button>
                </div>
                <div class="deposit-details">
                    <div id="btc-details" style="display: none;">
                        <p>Minimum deposit: 0.001 BTC</p>
                        <p>Expected Arrival: After 1 network confirmation</p>
                        <p>Minimum Available: After 2 network confirmations</p>
                    </div>
                    <div id="eth-details" style="display: none;">
                        <p>Minimum deposit: 0.01 ETH</p>
                        <p>Expected Arrival: After 6 network confirmations</p>
                        <p>Minimum Available: After 30 network confirmations</p>
                    </div>
                    <div id="usdt-details" style="display: none;">
                        <p>Minimum deposit: 10 USDT</p>
                        <p>Expected Arrival: After 6 network confirmations</p>
                        <p>Minimum Available: After 30 network confirmations</p>
                    </div>
                </div>
            </div>

            <div class="recent-activity">
                <h3>Recent Activity</h3>
                <table id="activity-table" class="responsive-table">
    <thead>
        <tr>
            <th>Transaction Type</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($transactions) {
            foreach ($transactions as $transaction) {
                echo "<tr>
                        <td class='td-type'>" . htmlspecialchars($transaction['transaction_type']) . "</td>
                        <td class='td-amount'>" . htmlspecialchars($transaction['amount']) . "</td>
                        <td class='td-date'>" . htmlspecialchars($transaction['created_at']) . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No recent activity found.</td></tr>";
        }
        ?>
    </tbody>
</table>

            </div>
        </div>
    </main>

    <script src="clientportal.js"></script> <!-- Link to your JavaScript file -->
</body>
</html>

<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$userId = $_SESSION['user']['userId']; 

include('php/connection.php'); 

$query = "SELECT id, transaction_type, amount, created_at, status 
          FROM balance_transactions 
          WHERE user_id = :user_id AND transaction_type = 'withdrawal' 
          ORDER BY created_at DESC";
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
    <link rel="stylesheet" href="test.css"> <!-- Link to your CSS file -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/main.js"></script>
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
                <li>
                    <a href="clientportal.php">Dashboard</a>
                </li>
                <li>
                    <a href="deposit.php">Deposit</a>
                </li>
                <li>
                    <a href="withdraw.php" class="active">Withdrawal</a>
                </li>
                <li class="become-partner"><a href="tradingplatform.php" class="nav__link become-partner">Open Trading Platform</a></li>
            </ul>
        </div>
    </nav>
        <!-- Main content -->
        <main>
            <!-- Your main content goes here -->
            <div class="container-main">
                <div class="main-form">
                <div class="form-group">
                    <h5>Withdraw Funds</h5>
                    <label for="transfer-method">Transfer Method</label>
                    <input type="text" id="transfer-method" value="Crypto" placeholder="Crypto" readonly>
                </div>
                <div class="form-group">
                    <label for="coin">Coin</label>
                    <select id="coin">
                        <option value="">Choose Coin</option>
                        <option value="BTC">BTC</option>
                        <option value="ETH">ETH</option>
                        <option value="USDT">USDT (ERC-20)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="wallet-address">Wallet Address</label>
                    <input type="text" id="wallet-address" placeholder="Enter Address">
                </div>
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="number" id="amount" placeholder="Enter Amount in USD">
                </div>
                <div class="form-group">
                    <label for="receiving-amount">Receiving Amount:</label>
                    <span id="receiving-amount">0</span>
                </div>
                <button id="submit-withdrawal">Submit Withdrawal</button>
                </div>
                
                <div class="recent-activity">
                    <h3>Recent Activity</h3>
                    <table id="transactions-table" class="responsive-table">
                        <thead>
                            <tr>
                                <th>Transaction Type</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Cancel Withdrawal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($transactions) {
                                foreach ($transactions as $transaction) {
                                    $cancelButton = ($transaction['status'] == "pending") ? 
                                    "<button class='cancel-btn' data-transaction-id='" . $transaction['id'] . "'>Cancel</button>" : 
                                    '';
                                    echo "<tr id='transaction-{$transaction['id']}'>
                                            <td class='td-type'>" . htmlspecialchars($transaction['transaction_type']) . "</td>
                                            <td class='td-amount'>" . htmlspecialchars($transaction['amount']) . "</td>
                                            <td class='td-date'>" . htmlspecialchars($transaction['created_at']) . "</td>
                                            <td class='td-status'>" . (($transaction['status'] == "pending") ? "Pending" : "Approved") . "</td>
                                            <td class='td-cancel'> $cancelButton </td>
                                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No recent withdrawals found.</td></tr>";
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
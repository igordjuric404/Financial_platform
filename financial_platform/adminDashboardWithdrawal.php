<?php
session_start();

// Proveravamo da li je korisnik admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include('php/connection.php');  // Konekcija sa bazom

// SQL upit sa JOIN za dohvat email-a korisnika
$query = "SELECT bt.id, bt.amount, bt.created_at, bt.status, bt.user_id, bt.coin, bt.wallet_address, u.email AS user_email
          FROM balance_transactions bt
          JOIN users u ON bt.user_id = u.id
          WHERE bt.transaction_type = 'withdrawal' AND bt.status = 'pending'
          ORDER BY bt.created_at DESC";
$stmt = $conn->prepare($query);
$stmt->execute();
$pendingWithdrawals = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .approve-btn {
            padding: 6px 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .approve-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <h2>Pending Withdrawals</h2>

    <table>
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>User Email</th>
                <th>Coin</th>
                <th>Wallet Address</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Status</th>
                <th>Approve</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($pendingWithdrawals) {
                foreach ($pendingWithdrawals as $withdrawal) {
                    echo "<tr>
                        <td>" . htmlspecialchars($withdrawal['id']) . "</td>
                        <td>" . htmlspecialchars($withdrawal['user_email']) . "</td>
                        <td>" . htmlspecialchars($withdrawal['coin']) . "</td>
                        <td>" . htmlspecialchars($withdrawal['wallet_address']) . "</td>
                        <td>" . htmlspecialchars($withdrawal['amount']) . "</td>
                        <td>" . htmlspecialchars($withdrawal['created_at']) . "</td>
                        <td>Pending</td>
                        <td><button class='approve-btn' data-transaction-id='" . $withdrawal['id'] . "'>Approve</button></td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No pending withdrawals.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script src="js/admin.js"></script>
</body>
</html>
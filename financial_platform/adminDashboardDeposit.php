<?php
session_start();

// Proveravamo da li je korisnik ulogovan i da li ima "admin" ulogu
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Proveravamo da li je admin email postavljen u sesiji
$adminEmail = isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : null;
if (!$adminEmail) {
    die('Error: Admin email is missing.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('php/connection.php');  // Konekcija sa bazom

    $email = trim($_POST['email']);
    $amount = trim($_POST['amount']);

    if (!empty($email) && is_numeric($amount) && $amount > 0) {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $newBalance = $user['balance'] + $amount;
            $updateQuery = "UPDATE users SET balance = :balance WHERE email = :email";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bindParam(':balance', $newBalance);
            $updateStmt->bindParam(':email', $email);
            $updateStmt->execute();

            $transactionQuery = "INSERT INTO balance_transactions (user_id, amount, transaction_type, admin_email)
                                  VALUES (:user_id, :amount, 'deposit', :admin_email)";
            $transactionStmt = $conn->prepare($transactionQuery);
            $transactionStmt->bindParam(':user_id', $user['id']);
            $transactionStmt->bindParam(':amount', $amount);
            $transactionStmt->bindParam(':admin_email', $adminEmail);
            $transactionStmt->execute();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Balance</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f6fa;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        padding-top: 50px;
    }

    h1 {
        text-align: center;
        color: #333;
        margin-bottom: 30px;
    }

    form {
        background-color: #fff;
        padding: 30px 40px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        width: 350px;
        display: flex;
        flex-direction: column;
    }

    form div {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 6px;
        color: #555;
        font-weight: bold;
    }

    input[type="email"],
    input[type="number"] {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        font-size: 16px;
        transition: border-color 0.3s;
    }

    input[type="email"]:focus,
    input[type="number"]:focus {
        border-color: #4CAF50;
        outline: none;
    }

    button {
        width: 100%;
        padding: 12px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #45a049;
    }

    .message {
        margin-top: 15px;
        font-size: 14px;
    }

    .message.success {
        color: green;
    }

    .message.error {
        color: red;
    }

    @media (max-width: 400px) {
        form {
            width: 90%;
            padding: 20px;
        }
    }
</style>
</head>
<body>

<h1>Add Balance to User</h1>

<form method="POST" action="">
    <div>
        <label for="email">User Email:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <label for="amount">Amount to Add:</label>
        <input type="number" id="amount" name="amount" step="0.01" required>
    </div>
    <div>
        <button type="submit">Add Balance</button>
    </div>
</form>

</body>
</html>
<?php
session_start(); 

if (!isset($_SESSION['user']) || !is_array($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

include('connection.php');

$transactionId = $_POST['transaction_id'];
$userId = $_SESSION['user']['userId'];
try {
    $conn->beginTransaction();

    $queryCheck = "SELECT * FROM balance_transactions WHERE id = :transactionId AND user_id = :userId AND status = 'pending'";
    $stmtCheck = $conn->prepare($queryCheck);
    $stmtCheck->bindParam(':transactionId', $transactionId);
    $stmtCheck->bindParam(':userId', $userId);
    $stmtCheck->execute();

    $transaction = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if (!$transaction) {
        echo json_encode(['success' => false, 'message' => 'Transaction not found or not pending']);
        exit;
    }

    $queryDelete = "DELETE FROM balance_transactions WHERE id = :transactionId";
    $stmtDelete = $conn->prepare($queryDelete);
    $stmtDelete->bindParam(':transactionId', $transactionId);
    $stmtDelete->execute();

    $amount = $transaction['amount'];
    $queryUpdateBalance = "UPDATE users SET balance = balance + :amount WHERE id = :userId";
    $stmtUpdateBalance = $conn->prepare($queryUpdateBalance);
    $stmtUpdateBalance->bindParam(':amount', $amount);
    $stmtUpdateBalance->bindParam(':userId', $userId);
    $stmtUpdateBalance->execute();

    $conn->commit();

    $_SESSION['user']['balance'] += $amount;

    echo json_encode(['success' => true, 'message' => 'Withdrawal canceled successfully']);
} catch (Exception $e) {
    $conn->rollBack();
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>

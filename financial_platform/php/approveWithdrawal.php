<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('connection.php');

    $transactionId = $_POST['transaction_id'];

    if (empty($transactionId)) {
        echo json_encode(['success' => false, 'message' => 'Transaction ID is required']);
        exit;
    }

    $queryCheck = "SELECT * FROM balance_transactions WHERE id = :transaction_id AND status = 'pending'";
    $stmtCheck = $conn->prepare($queryCheck);
    $stmtCheck->bindParam(':transaction_id', $transactionId, PDO::PARAM_INT);
    $stmtCheck->execute();

    $transaction = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if (!$transaction) {
        echo json_encode(['success' => false, 'message' => 'Transaction not found or already processed']);
        exit;
    }

    $queryUpdate = "UPDATE balance_transactions SET status = 1 WHERE id = :transaction_id";
    $stmtUpdate = $conn->prepare($queryUpdate);
    $stmtUpdate->bindParam(':transaction_id', $transactionId, PDO::PARAM_INT);

    if ($stmtUpdate->execute()) {
        echo json_encode(['success' => true, 'message' => 'Withdrawal approved successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating transaction']);
    }
}
?>

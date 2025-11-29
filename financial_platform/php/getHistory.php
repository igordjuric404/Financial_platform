<?php
session_start();

if (!isset($_SESSION['user']) || !is_array($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

include('connection.php');

$userId = $_SESSION['user']['userId'];

try {
    $query = "SELECT symbol, size, opening_price, latest_price, close_time, transaction_type, profit_loss 
              FROM deals_history WHERE user_id = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();

    $deals = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($deals) {
        echo json_encode(['success' => true, 'deals' => $deals]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No history found']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>
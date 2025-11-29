<?php
session_start();

if (!isset($_SESSION['user']) || !is_array($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

include('connection.php');

$userId = $_SESSION['user']['userId'];

try {
    $query = "SELECT id as deal_id, symbol, size, opening, transaction_type, stop_at, limit_at FROM deals WHERE user_id = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();

    $deals = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($deals) {
        echo json_encode(['success' => true, 'deals' => $deals]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No deals found']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>
<?php
session_start();

if (!isset($_SESSION['user']) || !is_array($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

include('connection.php');

// User ID kao u getHistory
$userId = $_SESSION['user']['userId'];

try {
    // Čitanje iz orders tabele
    $query = "
        SELECT 
            symbol,
            size,
            order_price,
            transaction_type,
            stop_at,
            limit_at,
            created_at
        FROM orders
        WHERE user_id = :user_id
        ORDER BY created_at DESC
    ";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();

    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($orders) {
        echo json_encode(['success' => true, 'orders' => $orders]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No orders found']);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>
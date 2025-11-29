<?php
session_start();
include('connection.php');

if (!isset($_SESSION['user']['userId'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$userId = $_SESSION['user']['userId'];

try {
    $stmt = $conn->prepare("
        SELECT d.id as deal_id, d.symbol, d.size, d.opening AS opening_price
        FROM deals d
        WHERE d.user_id = :user_id
    ");
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
    $deals = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'deals' => $deals
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

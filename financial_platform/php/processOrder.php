<?php
session_start();

if (!isset($_SESSION['user']) || !is_array($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

include('connection.php');

$userId = $_POST['user_id'];
$size = floatval($_POST['size']);
$orderPrice = floatval($_POST['order_price']);
$symbol = $_POST['symbol'];
$margin = floatval($_POST['margin']);
$transactionType = $_POST['transaction_type'];

$stopAt = floatval($_POST['stop_at']);
$limitAt = floatval($_POST['limit_at']);

try {
    $conn->beginTransaction();

    $queryInsertOrder = "INSERT INTO orders (user_id, size, order_price, symbol, margin, transaction_type, stop_at, limit_at) 
                         VALUES (:user_id, :size, :order_price, :symbol, :margin, :transaction_type, :stop_at, :limit_at)";

    $stmtInsertOrder = $conn->prepare($queryInsertOrder);
    $stmtInsertOrder->bindParam(':user_id', $userId);
    $stmtInsertOrder->bindParam(':size', $size);
    $stmtInsertOrder->bindParam(':order_price', $orderPrice);
    $stmtInsertOrder->bindParam(':symbol', $symbol);
    $stmtInsertOrder->bindParam(':margin', $margin);
    $stmtInsertOrder->bindParam(':transaction_type', $transactionType);
    $stmtInsertOrder->bindParam(':stop_at', $stopAt);
    $stmtInsertOrder->bindParam(':limit_at', $limitAt);

    $stmtInsertOrder->execute();

    $conn->commit();
    echo json_encode(['success' => true, 'message' => 'Order successfully placed!']);

} catch (Exception $e) {
    $conn->rollBack();
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>

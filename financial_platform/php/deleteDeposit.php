<?php
session_start();
include('connection.php');

if (!isset($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'Deposit ID missing']);
    exit;
}

$depositId = intval($_POST['id']);

try {
    $stmt = $conn->prepare("DELETE FROM deposits WHERE id = :id");
    $stmt->execute([':id' => $depositId]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Deposit deleted']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Deposit not found']);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>

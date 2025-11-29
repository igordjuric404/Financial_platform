<?php
session_start();

if (!isset($_SESSION['user']) || !is_array($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

include('connection.php'); // Tvoja PDO konekcija u $conn

$userId = $_SESSION['user']['userId'];

try {
    $query = "SELECT balance FROM users WHERE id = :user_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        // Osveži sesiju sa novim balance-om
        $_SESSION['user']['balance'] = $row['balance'];

        echo json_encode([
            'success' => true,
            'balance' => $row['balance']
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'User not found']);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>
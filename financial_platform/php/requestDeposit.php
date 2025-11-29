<?php
session_start();
include('connection.php');

// Provera da li je korisnik ulogovan
if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$userId = $_SESSION['user']['userId'];
$coin = $_POST['coin'] ?? '';
$amount = floatval($_POST['amount'] ?? 0);

// Validacija coina i minimalnog depozita
$minDeposits = [
    'BTC' => 0.001,
    'ETH' => 0.01,
    'USDT' => 10
];

if (!isset($minDeposits[$coin])) {
    echo json_encode(['success' => false, 'message' => 'Invalid coin selected']);
    exit;
}

if ($amount < $minDeposits[$coin]) {
    echo json_encode([
        'success' => false, 
        'message' => "Minimum deposit for {$coin} is: {$minDeposits[$coin]}"
    ]);
    exit;
}

// Ubacivanje depozita u bazu
try {
    $stmt = $conn->prepare("INSERT INTO deposits (user_id, coin, amount, status) VALUES (:user_id, :coin, :amount, 'pending')");
    $stmt->execute([
        ':user_id' => $userId,
        ':coin' => $coin,
        ':amount' => $amount
    ]);

    echo json_encode(['success' => true, 'message' => 'Deposit request successfully submitted!']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>

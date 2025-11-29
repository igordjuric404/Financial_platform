<?php
include('connection.php');

// POST podaci
$userId = intval($_POST['user_id'] ?? 0);
$size = floatval($_POST['size'] ?? 0);
$opening = floatval($_POST['opening'] ?? 0);
$symbol = $_POST['symbol'] ?? '';
$margin = floatval($_POST['margin'] ?? 0);
$transactionType = strtoupper($_POST['transaction_type'] ?? '');
$stopAt = isset($_POST['stop_at']) && $_POST['stop_at'] !== '' ? floatval($_POST['stop_at']) : null;
$limitAt = isset($_POST['limit_at']) && $_POST['limit_at'] !== '' ? floatval($_POST['limit_at']) : null;

try {
    $conn->beginTransaction();

    // 1️⃣ Provera da li user postoji
    $stmt = $conn->prepare("SELECT id, balance FROM users WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $conn->rollBack();
        echo json_encode(['success' => false, 'message' => 'Invalid user']);
        exit;
    }

    $funds = floatval($user['balance']);

    // 2️⃣ Uzmi sve otvorene dealove korisnika i izračunaj totalPL i totalMargin
    $stmt = $conn->prepare("SELECT size, opening, symbol, transaction_type, margin FROM deals WHERE user_id = :user_id");
    $stmt->execute([':user_id' => $userId]);
    $deals = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalPL = 0;
    $totalMargin = 0;
    $spreadPercent = 0.001;

    foreach ($deals as $deal) {
        $latestPrice = getLatestPrice($deal['symbol']);
        $buyPrice = $latestPrice * (1 + $spreadPercent / 2);
        $sellPrice = $latestPrice * (1 - $spreadPercent / 2);

        $dealType = strtoupper($deal['transaction_type']);

        // PL računamo prema tipu
        $priceForPL = $dealType === 'BUY' ? $sellPrice : $buyPrice;
        $profitLoss = ($priceForPL - $deal['opening']) * abs($deal['size']) * 0.1;
        $totalPL += $profitLoss;

        // Margin koristi se ono što je već rezervisano u deal-u
        $totalMargin += floatval($deal['margin']);
    }

    $available = ($funds + $totalPL) - $totalMargin;

    // 3️⃣ Provera dostupnih sredstava
    if ($available < $margin) {
        $conn->rollBack();
        echo json_encode([
            'success' => false,
            'message' => 'Insufficient available funds'
        ]);
        exit;
    }

    // 4️⃣ Insert novog deal-a
    $stmtInsertDeal = $conn->prepare("
        INSERT INTO deals 
        (user_id, size, opening, symbol, margin, transaction_type, stop_at, limit_at) 
        VALUES 
        (:user_id, :size, :opening, :symbol, :margin, :transaction_type, :stop_at, :limit_at)
    ");
    $stmtInsertDeal->execute([
        ':user_id' => $userId,
        ':size' => $size,
        ':opening' => $opening,
        ':symbol' => $symbol,
        ':margin' => $margin,
        ':transaction_type' => $transactionType,
        ':stop_at' => $stopAt,
        ':limit_at' => $limitAt
    ]);

    $conn->commit();
    echo json_encode(['success' => true, 'message' => 'Deal successfully placed!']);

} catch (Exception $e) {
    $conn->rollBack();
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}

/**
 * Dohvatanje aktuelne cene sa API-ja
 */
function getLatestPrice($symbol) {
    $apiKey = '58102220f146405c939ceec954eab48e';
    $apiUrl = "https://api.twelvedata.com/price?symbol={$symbol}&apikey={$apiKey}";
    $json = @file_get_contents($apiUrl);
    $data = json_decode($json, true);
    return isset($data['price']) ? floatval($data['price']) : 0;
}
?>
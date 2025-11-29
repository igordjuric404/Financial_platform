<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dealId = $_POST['deal_id'];  
    $size = floatval($_POST['size']);
    $symbol = $_POST['symbol'];
    $openingPrice = floatval($_POST['openingPrice']);
    $latestPrice = floatval($_POST['latestPrice']);

    // Dohvati user_id
    $userId = isset($_POST['user_id']) ? $_POST['user_id'] : (isset($_SESSION['user']['userId']) ? $_SESSION['user']['userId'] : null);
    
    if ($userId === null) {
        echo json_encode(['success' => false, 'message' => 'User ID nije pronađen']);
        exit;
    }

    include('connection.php');

    // -----------------------------
    // Definiši Forex, Commodities i Stocks
    // -----------------------------
    $forexSpecs = [
        "EUR/USD" => ["lotSize" => 100000, "quote" => "USD"],
        "USD/JPY" => ["lotSize" => 100000, "quote" => "JPY"],
        "GBP/USD" => ["lotSize" => 100000, "quote" => "USD"],
        "AUD/USD" => ["lotSize" => 100000, "quote" => "USD"],
        "NZD/USD" => ["lotSize" => 100000, "quote" => "USD"],
        "USD/CAD" => ["lotSize" => 100000, "quote" => "CAD"],
        "USD/CHF" => ["lotSize" => 100000, "quote" => "CHF"]
    ];

    $commodityLotSizes = [
        "WTI/USD" => 1000,
        "XBR/USD" => 1000,
        "XAU/USD" => 100,
        "XAG/USD" => 5000,
        "XPD/USD" => 100,
        "XPT/USD" => 100,
        "LMAHDS03" => 25,
        "HG1" => 25000,
        "NG/USD" => 10000,
        "KC1" => 37500,
        "CC1" => 10,
        "SB1" => 112000,
        "W_1" => 5000,
        "S_1" => 5000
    ];

    $stockSymbols = ['AAPL','GOOG','AMZN','MSFT','TSLA','META','NVDA','BRK.B','JPM','WMT','V','LLY','ORCL','MA','NFLX','XOM','JNJ','COST','HD','PLTR','ABBV','PG','BAC','CVX','KO','TMUS','GE','BABA','UNH','AMD','PM','CSCO','WFC','CRM','MS','ABT'];

    // -----------------------------
    // Izračunaj profit/loss
    // -----------------------------
    $profitLoss = 0;

    if (!is_nan($size) && !is_nan($openingPrice)) {
        if (isset($forexSpecs[$symbol])) {
            $lotSize = $forexSpecs[$symbol]['lotSize'];
            $diff = $latestPrice - $openingPrice;
            $pl = $diff * $lotSize * $size;

            if (str_starts_with($symbol, "USD/")) {
                $pl = $pl / $latestPrice;
            }

            $profitLoss = $pl;

        } else if (isset($commodityLotSizes[$symbol])) {
            $lotSize = $commodityLotSizes[$symbol];
            $diff = $latestPrice - $openingPrice;
            $profitLoss = $diff * $lotSize * $size;

        } else if (in_array($symbol, $stockSymbols)) {
            $lotSize = 100;
            $diff = $latestPrice - $openingPrice;
            $profitLoss = $diff * $lotSize * $size;

        } else {
            $profitLoss = ($latestPrice - $openingPrice) * abs($size) * 0.1;
        }
    }

    try {
        // -----------------------------
        // Zabeleži u istoriju
        // -----------------------------
        $queryHistory = "INSERT INTO deals_history (user_id, symbol, size, opening_price, latest_price, close_time, transaction_type, profit_loss)
                         VALUES (:user_id, :symbol, :size, :opening_price, :latest_price, NOW(), 'sell', :profit_loss)";
                         
        $stmtHistory = $conn->prepare($queryHistory);
        $stmtHistory->bindParam(':user_id', $userId);
        $stmtHistory->bindParam(':symbol', $symbol);
        $stmtHistory->bindParam(':size', $size);
        $stmtHistory->bindParam(':opening_price', $openingPrice);
        $stmtHistory->bindParam(':latest_price', $latestPrice);
        $stmtHistory->bindParam(':profit_loss', $profitLoss);
        $stmtHistory->execute();

        // -----------------------------
        // Obriši otvorenu poziciju
        // -----------------------------
        $queryDeleteDeal = "DELETE FROM deals WHERE user_id = :user_id AND id = :deal_id";
        $stmtDelete = $conn->prepare($queryDeleteDeal);
        $stmtDelete->bindParam(':user_id', $userId);
        $stmtDelete->bindParam(':deal_id', $dealId);
        $stmtDelete->execute();

        // -----------------------------
        // Update balansa korisnika
        // -----------------------------
        $queryUpdateBalance = "UPDATE users SET balance = balance + :profit_loss WHERE id = :user_id";
        $stmtUpdateBalance = $conn->prepare($queryUpdateBalance);
        $stmtUpdateBalance->bindParam(':profit_loss', $profitLoss);
        $stmtUpdateBalance->bindParam(':user_id', $userId);
        $stmtUpdateBalance->execute();

        if (isset($_SESSION['user']['userId']) && $_SESSION['user']['userId'] == $userId) {
            $_SESSION['user']['balance'] += $profitLoss;
        }

        // -----------------------------
        // Dohvati novi balans
        // -----------------------------
        $queryGetNewBalance = "SELECT balance FROM users WHERE id = :user_id";
        $stmtGetBalance = $conn->prepare($queryGetNewBalance);
        $stmtGetBalance->bindParam(':user_id', $userId);
        $stmtGetBalance->execute();
        $userBalance = $stmtGetBalance->fetchColumn();

        echo json_encode([
            'success' => true,
            'new_balance' => $userBalance,
            'profit_loss' => $profitLoss
        ]);

    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
}
?>
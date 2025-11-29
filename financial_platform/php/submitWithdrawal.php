<?php
session_start();

// Proveravamo da li su podaci poslati putem POST-a
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('connection.php');  // Uključi konekciju sa bazom

    // Uzimanje podataka iz POST zahteva
    try {
        // Preuzimanje podataka iz AJAX zahteva
        $coin = trim($_POST['coin']);
        $walletAddress = trim($_POST['walletAddress']);
        $amount = trim($_POST['amount']);
        $userId = $_SESSION['user']['userId'];  // ID korisnika iz sesije

        // Proveravamo da li je količina validna (veća od 0)
        if ($amount <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid withdrawal amount']);
            exit;
        }

        // Uzimamo trenutni balans korisnika iz baze
        $queryBalance = "SELECT balance FROM users WHERE id = :userId";
        $stmtBalance = $conn->prepare($queryBalance);
        $stmtBalance->bindParam(':userId', $userId);
        $stmtBalance->execute();
        $userBalance = $stmtBalance->fetchColumn();

        // Proveravamo da li korisnik ima dovoljno sredstava
        if ($userBalance < $amount) {
            echo json_encode(['success' => false, 'message' => 'Insufficient funds']);
            exit;
        }

        // Smanjujemo balans korisnika u bazi
        $newBalance = $userBalance - $amount;
        $queryUpdateBalance = "UPDATE users SET balance = :newBalance WHERE id = :userId";
        $stmtUpdateBalance = $conn->prepare($queryUpdateBalance);
        $stmtUpdateBalance->bindParam(':newBalance', $newBalance);
        $stmtUpdateBalance->bindParam(':userId', $userId);
        $stmtUpdateBalance->execute();

        // Dodajemo transakciju u tabelu balance_transactions
        $transactionType = 'withdrawal';  // Definišemo tip transakcije kao withdrawal
        $status = "pending";  // Ovdje stavljaš status u false jer povlačenje još nije obavljeno
        $queryInsertTransaction = "INSERT INTO balance_transactions (user_id, amount, transaction_type, status, created_at, coin, wallet_address) 
                                  VALUES (:userId, :amount, :transactionType, :status, NOW(), :coin, :walletAddress)";
        $stmtInsertTransaction = $conn->prepare($queryInsertTransaction);
        $stmtInsertTransaction->bindParam(':userId', $userId);
        $stmtInsertTransaction->bindParam(':amount', $amount);
        $stmtInsertTransaction->bindParam(':transactionType', $transactionType);
        $stmtInsertTransaction->bindParam(':status', $status);  // Ovdje možemo postaviti status u false
        $stmtInsertTransaction->bindParam(':coin', $coin);
        $stmtInsertTransaction->bindParam(':walletAddress', $walletAddress);
        $stmtInsertTransaction->execute();

        $_SESSION['user']['balance'] -= $amount;

        // Vraćamo JSON odgovor sa statusom uspešnosti
        echo json_encode(['success' => true, 'message' => 'Withdrawal request submitted successfully']);
        
    } catch (PDOException $ex) {
        // U slučaju greške u bazi
        echo json_encode(['success' => false, 'message' => 'Error: ' . $ex->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>

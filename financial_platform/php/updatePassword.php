<?php
session_start();
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user']['userId'])) {
        echo "User not logged in.";
        exit;
    }

    $userId = $_SESSION['user']['userId'];
    $currentPassword = trim($_POST['currentPassword'] ?? '');
    $newPassword = trim($_POST['newPassword'] ?? '');

    if (empty($currentPassword) || empty($newPassword)) {
        echo "Please fill in all fields.";
        exit;
    }

    try {
        // 1️⃣ Dohvati trenutnu hash lozinku iz baze
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = :userId");
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        $hashedPassword = $stmt->fetchColumn();

        if (!$hashedPassword) {
            echo "User not found.";
            exit;
        }

        // 2️⃣ Provera da li trenutna lozinka odgovara
        if (!password_verify($currentPassword, $hashedPassword)) {
            echo "Current password is incorrect.";
            exit;
        }

        // 3️⃣ Hashiranje nove lozinke
        $newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        // 4️⃣ Update lozinke u bazi
        $updateStmt = $conn->prepare("UPDATE users SET password = :newPassword WHERE id = :userId");
        $updateStmt->bindParam(':newPassword', $newHashedPassword);
        $updateStmt->bindParam(':userId', $userId);

        if ($updateStmt->execute()) {
            echo "success";
        } else {
            echo "Failed to update password.";
        }

    } catch (PDOException $ex) {
        http_response_code(500);
        echo "Error: " . $ex->getMessage();
    }
} else {
    echo "Invalid request method.";
}
?>

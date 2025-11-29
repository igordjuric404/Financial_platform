<?php

session_start();

// Provera da li su podaci poslati putem POST-a
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('connection.php');  // Uključi konekciju sa bazom

    // Uzimanje podataka iz POST zahteva
    try {
        $firstName = trim($_POST['firstName']);
        $lastName = trim($_POST['lastName']);
        $dateOfBirthInput = trim($_POST['dateOfBirth']);
        
        // Convert DD/MM/YYYY to YYYY-MM-DD for MySQL
        if (preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', $dateOfBirthInput, $matches)) {
            $dateOfBirth = $matches[3] . '-' . $matches[2] . '-' . $matches[1]; // YYYY-MM-DD
        } else {
            $dateOfBirth = $dateOfBirthInput;
        }
        
        $phone = trim($_POST['phone']);
        $email = trim($_POST['email']);  // Novi podatak
        $password = trim($_POST['password']);  // Novi podatak
        $repeatPassword = trim($_POST['repeatPassword']);  // Novi podatak
        $country = trim($_POST['country']);  // Novi podatak

        $address = 'N/A';
        $zipCode = 'N/A';
        $city = 'N/A';
        $balance = 0.00;  // Početni balans (postavljamo odmah na 0.00)

        // Proveri da li se lozinke poklapaju
        if ($password !== $repeatPassword) {
            echo 'Error: Passwords do not match.';
            exit;
        }

        // Hashiranje lozinke (pre nego što je sačuvamo u bazu)
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Pozivanje funkcije koja proverava i unosi podatke u bazu
        $signupRes = signupCheck($firstName, $lastName, $dateOfBirth, $phone, $email, $hashedPassword, $country, $address, $zipCode, $city, $balance);
        
        if ($signupRes) {
            // Uzimanje ID-a korisnika koji je upravo ubačen
            $userId = getLastInsertedUserId();

            // Preuzimanje balansa za tog korisnika iz baze
            $queryBalance = "SELECT balance FROM users WHERE id = :userId";
            $stmtBalance = $conn->prepare($queryBalance);
            $stmtBalance->bindParam(':userId', $userId);
            $stmtBalance->execute();
            $userBalance = $stmtBalance->fetchColumn();

            // Preusmeravanje korisnika na clientportal.php
            $_SESSION['user'] = [
                'userId' => $userId,  // ID korisnika
                'firstName' => $firstName,  // Korisničko ime
                'lastName' => $lastName,    // Prezime
                'dateOfBirth' => $dateOfBirth,  // Datum rođenja
                'phone' => $phone,  // Telefon
                'email' => $email,  // Email
                'country' => $country,  // Zemlja
                'address' => $address,
                'zipCode' => $zipCode,
                'city' => $city,
                'balance' => $userBalance  // Dodajemo balans iz baze
            ];

            echo 'success';  // Ako je unos uspešan, pošaljemo success
        } else {
            echo 'Error: Failed to insert data into database.';  // Ako nije uspešno
        }

    } catch (PDOException $ex) {
        http_response_code(500);  // Greška servera
        echo 'Error: ' . $ex->getMessage();  // Loguj grešku za debagovanje
    }
} else {
    echo 'Invalid request method';
}

function signupCheck($firstName, $lastName, $dateOfBirth, $phone, $email, $password, $country, $address, $zipCode, $city, $balance) {
    if (empty($firstName) || empty($lastName) || empty($dateOfBirth) || empty($phone) || empty($email) || empty($password) || empty($country)) {
        echo 'Please fill in all fields.';
        exit;
    }

    global $conn;

    $query = "INSERT INTO users (firstName, lastName, dateOfBirth, phone, email, password, country, address, zipCode, city, balance) 
            VALUES (:firstName, :lastName, :dateOfBirth, :phone, :email, :password, :country, :address, :zipCode, :city, :balance)";

    $ready = $conn->prepare($query);

    $ready->bindParam(':firstName', $firstName);
    $ready->bindParam(':lastName', $lastName);
    $ready->bindParam(':dateOfBirth', $dateOfBirth);
    $ready->bindParam(':phone', $phone);
    $ready->bindParam(':email', $email);
    $ready->bindParam(':password', $password);
    $ready->bindParam(':country', $country);
    $ready->bindParam(':address', $address);
    $ready->bindParam(':zipCode', $zipCode);
    $ready->bindParam(':city', $city);
    $ready->bindParam(':balance', $balance);

    try {
        $success = $ready->execute();
    } catch (PDOException $e) {
        error_log("SQL Error: " . $e->getMessage());
        echo "Error executing query: " . $e->getMessage();
        exit;
    }

    if ($success) {
        return true;
    } else {
        return false;
    }
}

function getLastInsertedUserId() {
    global $conn;
    return $conn->lastInsertId();
}
?>
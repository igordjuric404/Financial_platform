<?php
session_start();
if (!isset($_SESSION['user'])) {
    echo 'Error: User not logged in.';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('connection.php');

    $email = trim($_POST['email']);
    $country = trim($_POST['country']);
    $address = trim($_POST['address']);
    $zipCode = trim($_POST['zipCode']);
    $city = trim($_POST['city']);

    $address = empty($address) ? 'N/A' : $address;
    $zipCode = empty($zipCode) ? 'N/A' : $zipCode;
    $city = empty($city) ? 'N/A' : $city;
    $country = empty($country) ? 'N/A' : $country;

    try {
        global $conn;
        $query = "UPDATE users SET country = :country, address = :address, zipCode = :zipCode, city = :city WHERE email = :email";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':zipCode', $zipCode);
        $stmt->bindParam(':city', $city);

        $success = $stmt->execute();

        if ($success) {
            $_SESSION['user']['country'] = $country;
            $_SESSION['user']['address'] = $address;
            $_SESSION['user']['zipCode'] = $zipCode;
            $_SESSION['user']['city'] = $city;
            echo 'ok';
        } else {
            echo 'Error: Failed to update data.';
        }

    } catch (PDOException $ex) {
        echo 'Error: ' . $ex->getMessage();
    }

} else {
    echo 'Invalid request method';
}
?>

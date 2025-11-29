<?php
session_start();
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include 'connection.php';

    try {

        $email = $_POST['email']; 
        $password = $_POST['password'];

        $loginRes = loginCheck($email, $password);

        error_log("Login result: " . print_r($loginRes, true));

        if ($loginRes) {
            $_SESSION['user'] = [
            'userId' => $loginRes['id'],
            'firstName' => $loginRes['firstName'], 
            'lastName' => $loginRes['lastName'],
            'dateOfBirth' => $loginRes['dateOfBirth'],
            'email' => $loginRes['email'],
            'phone' => $loginRes['phone'],
            'country' => $loginRes['country'],
            'address' => $loginRes['address'],
            'zipCode' => $loginRes['zipCode'],
            'city' => $loginRes['city'],
            'role' => $loginRes['role'],
            'balance' => $loginRes['balance']
        ];
            session_regenerate_id(true);

            echo json_encode(["message" => "ok"]);
            http_response_code(200);
        } else {
            echo json_encode(["message" => "Invalid email or password."]);
            http_response_code(401);
        }

    } catch (PDOException $ex) {
        echo json_encode(["message" => "Server error. Please try again later."]);
        http_response_code(500);
    }

}

function loginCheck($email, $password) {
    global $conn;

    $query = "SELECT * FROM users WHERE email = :email";
    $ready = $conn->prepare($query);
    $ready->bindParam(':email', $email);
    $ready->execute();

    $res = $ready->fetch(PDO::FETCH_ASSOC);

    error_log("DB Result: " . print_r($res, true));

    if ($res && password_verify($password, $res['password'])) {
        return $res;
    }

    return false;
}
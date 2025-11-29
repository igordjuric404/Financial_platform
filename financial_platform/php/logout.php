<?php
session_start();

if(isset($_SESSION['user'])){
    unset($_SESSION['user']);
}

session_destroy();

header('Location: ../index.php');
exit();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="0;url=../index.php">
    <title>Logging out...</title>
</head>
<body>
    <p>Logging out... <a href="../index.php">Click here if you are not redirected</a></p>
</body>
</html>

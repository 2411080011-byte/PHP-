<?php

require 'conexionPDO.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];

    $password = $_POST["password"];


    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");

    $stmt->execute([$username]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);


    if ($user && password_verify($password, $user["password"])) {

        $_SESSION["user_id"] = $user["id"];

        $_SESSION["username"] = $user["username"];

        echo "<script> window.location.href = 'index.php'</script>";

        exit;

    } else {
        echo "<script> window.location.href = 'login_2.0.php'</script>";
    }
} 

?>
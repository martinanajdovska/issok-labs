<?php
session_start();
require_once "../../database/db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = connect();

    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $db->prepare("INSERT INTO user (username,password) VALUES (:username, :password)");
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", $hashedPassword);
    try{
        $stmt->execute();
        echo "Registration is successful!";
        echo "<br>Login here <a href='../../pages/auth/login_form.php'></a>";
    } catch(PDOException $e) {
        echo $e->getMessage();
    }
}
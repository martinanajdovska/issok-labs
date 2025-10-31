<?php
session_start();

require_once "../../database/db_connect.php";
require_once "../../jwt_helper.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = connect();

    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $stmt = $db->prepare("SELECT * FROM user WHERE username = :username");
    $stmt->bindParam(":username", $username);
    $res = $stmt->execute();
    $user = $res->fetchArray(SQLITE3_ASSOC);

    if ($user && password_verify($password, $user['password'])){
        $token = createJWT($user['id'],$user['username'], $user['role']);
        session_regenerate_id(true);
        $_SESSION['jwt'] = $token;
        header("Location: ../../pages/index.php");
        exit;
    } else {
        echo "Invalid username or password";
        exit;
    }
}
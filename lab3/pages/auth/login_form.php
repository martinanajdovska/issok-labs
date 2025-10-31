<?php

session_start();
require_once "../../jwt_helper.php";

if (isset($_SESSION['jwt']) && decodeJWT($_SESSION['jwt'])) {
    header("Location: ../index.php");
    exit;
}
?>

<div>
    <h2>Login</h2>
    <form action="../../handler/auth/login.php" method="post">
        <div>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </div>
        <button type="submit">Login</button>
        <p>
            <a href="register_form.php">Register here</a>
        </p>
    </form>
</div>
<?php
require_once "../jwt_helper.php";

session_start();

if (!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])) {
    header("Location:./auth/login_form.php");
    exit;
}
?>

<form action="../handler/add.php" method="post">
    <label for="name">Name</label>
    <input type="text" id="name" name="name" required>
    <br>
    <label for="location">Location</label>
    <input type="text" id="location" name="location" required>
    <br>
    <label for="date">Date</label>
    <input type="date" id="date" name="date" required>
    <br>
    <label for="price">Price</label>
    <input type="number" id="price" name="price" required>
    <br>
    <select name="type">
        <option value="internal">Internal</option>
        <option value="external">External</option>
    </select>
    <button type="submit">Add</button>
</form>
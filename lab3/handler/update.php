<?php
include_once "../database/db_connect.php";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $db = connect();

    $id = intval($_POST["id"]);
    $name = $_POST["name"];
    $location = $_POST["location"];
    $date = $_POST["date"];
    $price = intval($_POST["price"]);
    $type = $_POST["type"];

    $query = "UPDATE camera SET name=:name, location=:location, date=:date, price=:price, type=:type WHERE id=:id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $id, SQLITE3_INTEGER);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":location", $location);
    $stmt->bindParam(":date", $date);
    $stmt->bindParam(":price", $price, SQLITE3_INTEGER);
    $stmt->bindParam(":type", $type);
    $stmt->execute();

    $db->close();
    header("Location: ../pages/index.php");
    exit;
} else {
    echo "Invalid request";
}
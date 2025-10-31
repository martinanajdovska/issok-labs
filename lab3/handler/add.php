<?php
include_once '../database/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $location = $_POST["location"];
    $type = $_POST["type"];
    $price = $_POST["price"];
    $date = $_POST["date"];

    $db = connect();

    $stmt = $db->prepare("INSERT INTO camera (name,location,date,price,type)
            VALUES (:name, :location, :date, :price, :type)");
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':location', $location);
    $stmt->bindValue(':date', $date);
    $stmt->bindValue(':price', $price);
    $stmt->bindValue(':type', $type);

    if ($stmt->execute()) {
        header("Location: ../pages/index.php");
    } else {
        echo "Something went wrong" . $db->lastErrorMsg();
    }

    $db->close();
} else {
    echo "Not a POST request";
}
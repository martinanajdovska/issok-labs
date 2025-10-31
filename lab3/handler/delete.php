<?php
include_once "../database/db_connect.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $db = connect();

    $stmt = $db->prepare("DELETE FROM camera WHERE id = :id AND julianday('now')-julianday(date)<=7");
    $stmt->bindParam(":id", $id, SQLITE3_INTEGER);
    $stmt->execute();

    if ($db->changes()===0){
        echo "Cannot be older than 7 days";
    } else {
        header("Location: ../pages/index.php");
    }

    $db->close();
    exit;
} else {
    echo "Not a POST request";
}
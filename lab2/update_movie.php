<?php
include 'connect_database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $year = intval($_POST['year']);

    $db = connectDatabase();

    // Update student details
    $stmt = $db->prepare("UPDATE movie SET title = :title, genre = :genre, year = :year WHERE id = :id");
    $stmt->bindValue(':title', $title, SQLITE3_TEXT);
    $stmt->bindValue(':genre', $genre, SQLITE3_TEXT);
    $stmt->bindValue(':year', $year, SQLITE3_INTEGER);
    $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
    $stmt->execute();

    // Close the database connection
    $db->close();

    // Redirect back to the view page
    header("Location: index.php");
    exit();
} else {
    echo "Invalid request.";
}
?>
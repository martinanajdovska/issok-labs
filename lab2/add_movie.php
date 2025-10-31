<?php
// Include the database connection file
include 'connect_database.php';

// Check if the request method is POST to handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form values from the POST request, with basic validation
    $title = $_POST['title'] ?? '';
    $genre = $_POST['genre'] ?? '';
    $year = (int) ($_POST['year'] ?? 0);

    // Validate required fields
    if (empty($title) || empty($genre) || $year <= 0) {
        echo "Please fill in all required fields correctly.";
        exit;
    }

    // Connect to the SQLite database
    $db = connectDatabase();

    // Prepare and execute the insert statement
    $stmt = $db->prepare("INSERT INTO movie (title, genre, year) VALUES (:title, :genre, :year)");
    $stmt->bindValue(':title', $title, SQLITE3_TEXT);
    $stmt->bindValue(':genre', $genre, SQLITE3_TEXT);
    $stmt->bindValue(':year', $year, SQLITE3_INTEGER);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        // Redirect back to the view page
        header("Location: index.php");
    } else {
        echo "Error adding movie: " . $db->lastErrorMsg();
    }

    // Close the database connection
    $db->close();
} else {
    // If not a POST request, display an error message
    echo "Invalid request method. Please submit the form to add a movie.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Movie</title>
</head>
<body>
<form action="add_movie.php" method="POST">
    <label for="title">Title:</label>
    <input type="text" name="title" id="title" required>
    <br />
    <label for="genre">Genre:</label>
    <input type="text" name="genre" id="genre" required>
    <br />
    <label for="year">Year:</label>
    <input type="number" name="year" id="year" required>
    <br />
    <button type="submit">Add Movie</button>
</form>
</body>
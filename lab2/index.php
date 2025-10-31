<?php

include 'connect_database.php';

$db = connectDatabase();

if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
    $query = "SELECT * FROM movie WHERE title like '%{$search}%'";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':search', $search);
    $result = $stmt->execute();
} else {
    $query = "SELECT * FROM movie";
    $result = $db->query($query);
}

if (isset($_GET['genre'])) {
    $genre = trim($_GET['genre']);
    $query = "SELECT * FROM movie WHERE genre like :genre";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':genre', $genre);
    $result = $stmt->execute();
} else {
    $query = "SELECT * FROM movie";
    $result = $db->query($query);
}

if (!$result) {
    die("Error fetching movies: " . $db->lastErrorMsg());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View movies</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
            text-align: left;
        }
    </style>
</head>
<body>
<div style="display: flex; align-items: center; justify-content: space-between">
    <h1>Student List</h1>
    <a href="add_movie_form.php">
        Add Movie
    </a>

    <form action="index.php" method="get" style="display:inline;">
        <select name="genre">
            <option value="horror">horror</option>
            <option value="action">action</option>
        </select>
        <input type="text" name="search" id="search">
        <button type="submit">Search</button>
    </form>
</div>
<table>
    <thead>
    <tr>
        <th>Title</th>
        <th>Genre</th>
        <th>Year</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($result): ?>
        <?php while ($movie = $result->fetchArray(SQLITE3_ASSOC)): ?>
            <tr>
                <td><?php echo htmlspecialchars($movie['title']); ?></td>
                <td><?php echo htmlspecialchars($movie['genre']); ?></td>
                <td><?php echo htmlspecialchars($movie['year']); ?></td>
                <td>
                    <form action="delete_movie.php" method="post" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $movie['id']; ?>">
                        <button type="submit">Delete</button>
                    </form>
                    <form action="update_movie_form.php" method="get" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $movie['id']; ?>">
                        <button type="submit">Update</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="5">No movies found.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
</body>
</html>



<?php
include_once '../database/db_connect.php';
require_once "../jwt_helper.php";

session_start();

if (!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])) {
    header("Location:./auth/login_form.php");
    exit;
}

$db = connect();

$query = "SELECT * FROM camera";
$result = $db->query($query);

if (!$result) {
    die("Database query failed: " . $db->lastErrorMsg());
}
?>
<form action="add_form.php" method="get">
    <button type="submit">Add</button>
</form>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Location</th>
            <th>Date</th>
            <th>Price</th>
            <th>Type</th>
        </tr>
    </thead>
    <tbody>
    <?php if ($result): ?>
        <?php while($row = $result->fetchArray(SQLITE3_ASSOC)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['location']); ?></td>
                <td><?php echo htmlspecialchars($row['date']); ?></td>
                <td><?php echo htmlspecialchars($row['price']); ?></td>
                <td><?php echo htmlspecialchars($row['type']); ?></td>
                <td>
                    <form action="../handler/delete.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $row['id'];?>">
                        <button type="submit">Delete</button>
                    </form>
                    <form action="update_form.php" method="get">
                        <input type="hidden" name="id" value="<?php echo $row['id'];?>">
                        <button type="submit">Update</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php endif; ?>
    </tbody>
</table>
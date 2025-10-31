<?php
include_once '../database/db_connect.php';
require_once "../jwt_helper.php";

session_start();

if (!isset($_SESSION['jwt']) || !decodeJWT($_SESSION['jwt'])) {
    header("Location:./auth/login_form.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $db = connect();

    $id = $_GET["id"];
    $stmt = $db->prepare("SELECT * FROM camera WHERE id = :id");
    $stmt ->bindValue(":id", $id, SQLITE3_INTEGER);
    $result = $stmt->execute();
    $camera = $result->fetchArray(SQLITE3_ASSOC);
} else {
    echo "Camera not found";
    exit;
}
?>
<form action="../handler/update.php" method="post">
    <input type="hidden" id="id" name="id" value="<?php echo htmlspecialchars($camera["id"]); ?>">
    <label for="name">Name</label>
    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($camera["name"])?>" required>
    <br>
    <label for="location">Location</label>
    <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($camera["location"])?>" required>
    <br>
    <label for="date">Date</label>
    <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($camera["date"])?>" required>
    <br>
    <label for="price">Price</label>
    <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($camera["price"])?>" required>
    <br>
    <select name="type">
        <option <?php echo htmlspecialchars($camera['type']) === 'internal' ? 'selected=true' : '';?> value="internal">Internal</option>
        <option <?php echo htmlspecialchars($camera['type']) === 'external' ? 'selected=true' : '';?> value="external">External</option>
    </select>
    <button type="submit">Update</button>
</form>

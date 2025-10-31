<?php
$db = new SQLite3(__DIR__ . '/database.sqlite');

$createTableQuery = "CREATE TABLE IF NOT EXISTS user (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL,
        password TEXT NOT NULL
)";

$db->exec($createTableQuery);

if ($db->exec($createTableQuery)) {
    echo "Table created";
} else {
    echo "Error creating table: " . $db->lastErrorMsg();
}

$db->close();
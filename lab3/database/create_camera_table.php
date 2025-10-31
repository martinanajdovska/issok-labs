<?php

$db = new SQLite3(__DIR__ . '/database.sqlite');

$createTableQuery = <<<SQL
CREATE TABLE IF NOT EXISTS camera(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    location TEXT NOT NULL,
    date DATETIME NOT NULL,
    price INTEGER NOT NULL,
    type TEXT NOT NULL
);
SQL;

if ($db->exec($createTableQuery)) {
    echo "Table created";
} else {
    echo "Error creating table: " . $db->lastErrorMsg();
}

$db->close();
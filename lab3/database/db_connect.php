<?php
function connect(){
    return new SQLite3(__DIR__ . '/database.sqlite');
}
?>
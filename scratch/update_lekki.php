<?php
$mysqli = new mysqli("127.0.0.1", "root", "", "fortunes_collection");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// 1. Update reviews
$mysqli->query("UPDATE reviews SET comment = REPLACE(comment, 'Lekki', 'Effurun') WHERE comment LIKE '%Lekki%'");
echo "Updated reviews: " . $mysqli->affected_rows . "\n";

// 2. Update any other table if Lekki is found
$tables = $mysqli->query("SHOW TABLES");
while ($row = $tables->fetch_row()) {
    $table = $row[0];
    $columns = $mysqli->query("SHOW COLUMNS FROM `$table`");
    while ($col = $columns->fetch_assoc()) {
        $fieldName = $col['Field'];
        $fieldType = $col['Type'];
        if (preg_match('/char|text/i', $fieldType)) {
            $mysqli->query("UPDATE `$table` SET `$fieldName` = REPLACE(`$fieldName`, 'Lekki', 'Effurun') WHERE `$fieldName` LIKE '%Lekki%'");
            if ($mysqli->affected_rows > 0) {
                echo "Updated $table.$fieldName: " . $mysqli->affected_rows . " rows\n";
            }
        }
    }
}

echo "Database Lekki purge complete!\n";

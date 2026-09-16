<?php
$mysqli = new mysqli("127.0.0.1", "root", "", "fortunes_collection");
$r = $mysqli->query("SELECT id, comment FROM reviews WHERE comment LIKE '%Lekki%'");
while ($row = $r->fetch_assoc()) {
    echo $row['id'] . ": " . $row['comment'] . "\n";
}

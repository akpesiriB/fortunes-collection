<?php
$mysqli = new mysqli("127.0.0.1", "root", "", "fortunes_collection");
$r = $mysqli->query("SELECT id, name, description FROM shipping_methods");
while ($row = $r->fetch_assoc()) {
    echo $row['id'] . " | " . $row['name'] . " | " . $row['description'] . "\n";
}

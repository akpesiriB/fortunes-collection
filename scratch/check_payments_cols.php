<?php
$mysqli = new mysqli("127.0.0.1", "root", "", "fortunes_collection");
$res = $mysqli->query("SHOW COLUMNS FROM payments");
while ($r = $res->fetch_assoc()) {
    echo $r['Field'] . " (" . $r['Type'] . ")\n";
}

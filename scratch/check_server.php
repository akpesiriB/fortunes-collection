<?php
$res = @file_get_contents('http://127.0.0.1:8000');
if ($res !== false) {
    echo "Server running on 8000\n";
} else {
    echo "Not running on 8000\n";
}

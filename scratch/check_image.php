<?php
$file = 'public/images/hero-master.jpg';
$info = getimagesize($file);
echo "Hero Master: " . $info[0] . "x" . $info[1] . " mime: " . $info['mime'] . PHP_EOL;

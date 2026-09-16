<?php
$srcPath = 'C:/Users/AYO OMUVWIE/.gemini/antigravity-ide/brain/4a61c6b3-54a3-4ff7-86c6-f9734050dfd2/.user_uploaded/media_1789119947460.png';
$im = imagecreatefrompng($srcPath);
$w = imagesx($im);
$h = imagesy($im);
echo "Image loaded: {$w}x{$h}\n";

// Let's check pixel colors in the background:
// Top-left corner, bottom-left, etc.
$c1 = imagecolorat($im, 10, 10);
$c2 = imagecolorat($im, 10, $h - 10);
$c3 = imagecolorat($im, 400, 100);
printf("Corner color: #%06X\n", $c1);
printf("Bottom corner: #%06X\n", $c2);
printf("Center void: #%06X\n", $c3);

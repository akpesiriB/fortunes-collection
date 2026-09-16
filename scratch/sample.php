<?php
$im = imagecreatefrompng('public/images/hero-haute.png');
$w = imagesx($im);
$h = imagesy($im);
echo "Image Size: {$w}x{$h}\n";

// Let's sample colors on x=50, 150, 250, 350
for ($y = 100; $y <= 400; $y += 50) {
    $rgb = imagecolorat($im, 150, $y);
    $r = ($rgb >> 16) & 0xFF;
    $g = ($rgb >> 8) & 0xFF;
    $b = $rgb & 0xFF;
    echo "y={$y} rgb=({$r},{$g},{$b})\n";
}

<?php
$src = imagecreatefrompng('public/images/hero-haute.png');
$w = imagesx($src);
$h = imagesy($src);

// Create a copy
$dst = imagecreatetruecolor($w, $h);
imagecopy($dst, $src, 0, 0, 0, 0, $w, $h);

// 1. Top left logo area (x: 50 to 220, y: 15 to 60)
// Notice in the original, the top left has the golden light ray on the very top left border (from (0,0) down to (300,0) / (0,300)),
// while at x: 50-220, y: 15-60 is a dark gradient.
// Let's sample colors around the logo text at x=100, y=10 and x=100, y=65.

// 2. Main text area: x: 90 to 500, y: 200 to 360
// Notice that for x from 90 to 500, y from 190 to 370, the background is a smooth dark foggy gradient.
// In fact, pixels at y=180-190 and y=370-380 have virtually identical colors (~#121114 to #18161B).
// Let's create an interpolated fill or seamless patch over the text area.

for ($x = 90; $x <= 510; $x++) {
    $topColor = imagecolorat($dst, $x, 190);
    $bottomColor = imagecolorat($dst, $x, 375);
    
    $tr = ($topColor >> 16) & 0xFF;
    $tg = ($topColor >> 8) & 0xFF;
    $tb = $topColor & 0xFF;
    
    $br = ($bottomColor >> 16) & 0xFF;
    $bg = ($bottomColor >> 8) & 0xFF;
    $bb = $bottomColor & 0xFF;
    
    for ($y = 191; $y < 375; $y++) {
        $ratio = ($y - 190) / (375 - 190);
        $r = (int)($tr * (1 - $ratio) + $br * $ratio);
        $g = (int)($tg * (1 - $ratio) + $bg * $ratio);
        $b = (int)($tb * (1 - $ratio) + $bb * $ratio);
        
        // Add subtle natural noise so it matches the photographic grain
        $noise = rand(-2, 2);
        $r = max(0, min(255, $r + $noise));
        $g = max(0, min(255, $g + $noise));
        $b = max(0, min(255, $b + $noise));
        
        $col = imagecolorallocate($dst, $r, $g, $b);
        imagesetpixel($dst, $x, $y, $col);
    }
}

// Top left badge area: x: 50 to 220, y: 20 to 60
for ($x = 50; $x <= 220; $x++) {
    $topColor = imagecolorat($dst, $x, 14);
    $bottomColor = imagecolorat($dst, $x, 65);
    $tr = ($topColor >> 16) & 0xFF;
    $tg = ($topColor >> 8) & 0xFF;
    $tb = $topColor & 0xFF;
    $br = ($bottomColor >> 16) & 0xFF;
    $bg = ($bottomColor >> 8) & 0xFF;
    $bb = $bottomColor & 0xFF;
    for ($y = 15; $y < 65; $y++) {
        $ratio = ($y - 14) / (65 - 14);
        $r = max(0, min(255, (int)($tr * (1 - $ratio) + $br * $ratio) + rand(-1, 1)));
        $g = max(0, min(255, (int)($tg * (1 - $ratio) + $bg * $ratio) + rand(-1, 1)));
        $b = max(0, min(255, (int)($tb * (1 - $ratio) + $bb * $ratio) + rand(-1, 1)));
        $col = imagecolorallocate($dst, $r, $g, $b);
        imagesetpixel($dst, $x, $y, $col);
    }
}

imagepng($dst, 'public/images/hero-clean-bg.png');
echo "Clean background created successfully!\n";

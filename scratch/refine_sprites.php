<?php
// High-grade background keying with color-distance fade
$srcPath = 'C:/Users/AYO OMUVWIE/.gemini/antigravity-ide/brain/4a61c6b3-54a3-4ff7-86c6-f9734050dfd2/.user_uploaded/media_1789119947460.png';
$src = imagecreatefrompng($srcPath);

function keyOutDarkBg($src, $sx, $sy, $w, $h, $outFile, $lowThresh = 14, $highThresh = 28) {
    $im = imagecreatetruecolor($w, $h);
    imagealphablending($im, false);
    imagesavealpha($im, true);
    $trans = imagecolorallocatealpha($im, 0, 0, 0, 127);
    imagefilledrectangle($im, 0, 0, $w, $h, $trans);

    for ($y = 0; $y < $h; $y++) {
        for ($x = 0; $x < $w; $x++) {
            $px = $sx + $x;
            $py = $sy + $y;
            if ($px >= imagesx($src) || $py >= imagesy($src)) continue;

            $rgb = imagecolorat($src, $px, $py);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;

            $brightness = ($r * 0.299 + $g * 0.587 + $b * 0.114);

            // Elliptical falloff from center to eliminate any bounding box edges
            $cx = $w / 2.0;
            $cy = $h / 2.0;
            $dx = ($x - $cx) / $cx;
            $dy = ($y - $cy) / $cy;
            $dist = sqrt($dx * $dx + $dy * $dy);
            $radialFactor = 1.0;
            if ($dist > 0.7) {
                $radialFactor = max(0, (1.0 - $dist) / 0.3);
            }

            if ($brightness <= $lowThresh || $radialFactor <= 0) {
                continue;
            }

            $alphaFactor = 1.0;
            if ($brightness < $highThresh) {
                $alphaFactor = ($brightness - $lowThresh) / ($highThresh - $lowThresh);
            }
            $finalFactor = $alphaFactor * $radialFactor;
            if ($finalFactor <= 0.02) continue;

            $alpha = (int)(127 * (1.0 - $finalFactor));
            $col = imagecolorallocatealpha($im, $r, $g, $b, $alpha);
            imagesetpixel($im, $x, $y, $col);
        }
    }

    imagealphablending($im, false);
    imagesavealpha($im, true);
    imagepng($im, $outFile);
    imagedestroy($im);
    echo "Saved {$outFile}\n";
}

$pDir = 'public/images/particles';

keyOutDarkBg($src, 712, 45, 110, 80, "$pDir/cloth_drape.png", 12, 24);
keyOutDarkBg($src, 608, 408, 52, 58, "$pDir/cloth_mini_shirt.png", 12, 24);
keyOutDarkBg($src, 815, 412, 165, 70, "$pDir/ribbon_gold.png", 12, 25);
keyOutDarkBg($src, 908, 126, 50, 42, "$pDir/hardware_hanger.png", 14, 26);
keyOutDarkBg($src, 512, 152, 54, 44, "$pDir/cloth_cuff_top.png", 12, 24);
keyOutDarkBg($src, 528, 287, 42, 42, "$pDir/cloth_cuff_mid.png", 12, 24);
keyOutDarkBg($src, 516, 338, 68, 88, "$pDir/cloth_sleeve.png", 12, 24);
keyOutDarkBg($src, 748, 458, 60, 80, "$pDir/cloth_cuff_shoe.png", 12, 24);

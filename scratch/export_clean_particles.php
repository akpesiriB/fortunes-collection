<?php
// Extract high-quality particle sprites from reference
$srcPath = 'C:/Users/AYO OMUVWIE/.gemini/antigravity-ide/brain/4a61c6b3-54a3-4ff7-86c6-f9734050dfd2/.user_uploaded/media_1789119947460.png';
$src = imagecreatefrompng($srcPath);
$sw = imagesx($src);
$sh = imagesy($src);

function exportCleanParticle($src, $sx, $sy, $w, $h, $outFile, $feather = 10, $blackThresh = 15) {
    $im = imagecreatetruecolor($w, $h);
    imagealphablending($im, false);
    imagesavealpha($im, true);
    $trans = imagecolorallocatealpha($im, 0, 0, 0, 127);
    imagefilledrectangle($im, 0, 0, $w, $h, $trans);
    imagealphablending($im, true);

    for ($y = 0; $y < $h; $y++) {
        for ($x = 0; $x < $w; $x++) {
            $px = $sx + $x;
            $py = $sy + $y;
            if ($px >= imagesx($src) || $py >= imagesy($src)) continue;

            $rgb = imagecolorat($src, $px, $py);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;

            // Distance to bounding box border
            $distX = min($x, $w - 1 - $x);
            $distY = min($y, $h - 1 - $y);
            $borderDist = min($distX, $distY);

            $brightness = ($r * 0.299 + $g * 0.587 + $b * 0.114);

            // Feather towards borders
            $borderAlpha = 1.0;
            if ($borderDist < $feather) {
                $borderAlpha = $borderDist / (float)$feather;
            }

            // Cut out flat background black
            $colorAlpha = 1.0;
            if ($brightness <= $blackThresh) {
                $colorAlpha = max(0, ($brightness - 5) / (float)($blackThresh - 5));
            }

            $finalAlphaFactor = $borderAlpha * $colorAlpha;
            if ($finalAlphaFactor <= 0.02) continue;

            $alpha = (int)(127 * (1.0 - $finalAlphaFactor));
            $col = imagecolorallocatealpha($im, $r, $g, $b, $alpha);
            imagesetpixel($im, $x, $y, $col);
        }
    }

    imagealphablending($im, false);
    imagesavealpha($im, true);
    imagepng($im, $outFile);
    imagedestroy($im);
    echo "Exported {$outFile}\n";
}

$pDir = 'public/images/particles';
if (!is_dir($pDir)) mkdir($pDir, 0777, true);

// 1. Top draped silk cloth
exportCleanParticle($src, 712, 45, 110, 80, "$pDir/cloth_drape.png", 6, 12);
// 2. Mini gold shirt
exportCleanParticle($src, 608, 408, 52, 58, "$pDir/cloth_mini_shirt.png", 5, 12);
// 3. Gold ribbon swatch
exportCleanParticle($src, 815, 412, 165, 70, "$pDir/ribbon_gold.png", 8, 14);
// 4. Gold hardware / hanger
exportCleanParticle($src, 908, 126, 50, 42, "$pDir/hardware_hanger.png", 4, 14);
// 5. Left floating cuff
exportCleanParticle($src, 512, 152, 54, 44, "$pDir/cloth_cuff_top.png", 5, 12);
// 6. Mid left floating cuff
exportCleanParticle($src, 528, 287, 42, 42, "$pDir/cloth_cuff_mid.png", 4, 12);
// 7. Lower left floating sleeve
exportCleanParticle($src, 516, 338, 68, 88, "$pDir/cloth_sleeve.png", 6, 12);
// 8. Lower cuff near shoe
exportCleanParticle($src, 748, 458, 60, 80, "$pDir/cloth_cuff_shoe.png", 6, 12);

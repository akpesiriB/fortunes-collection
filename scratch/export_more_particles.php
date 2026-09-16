<?php
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

// Coins
keyOutDarkBg($src, 932, 50, 32, 32, "$pDir/coin_top_right.png", 18, 30);
keyOutDarkBg($src, 514, 260, 32, 32, "$pDir/coin_left.png", 18, 30);
keyOutDarkBg($src, 920, 340, 36, 36, "$pDir/coin_mid_right.png", 18, 30);

// Bokeh orbs
keyOutDarkBg($src, 520, 480, 80, 75, "$pDir/bokeh_orb_1.png", 10, 22);
keyOutDarkBg($src, 860, 480, 80, 75, "$pDir/bokeh_orb_2.png", 10, 22);

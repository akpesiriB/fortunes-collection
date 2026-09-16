<?php
// Test separating the particles and inpainting the base background
$srcPath = 'C:/Users/AYO OMUVWIE/.gemini/antigravity-ide/brain/4a61c6b3-54a3-4ff7-86c6-f9734050dfd2/.user_uploaded/media_1789119947460.png';
$src = imagecreatefrompng($srcPath);
$w = imagesx($src);
$h = imagesy($src);

echo "Loaded reference {$w}x{$h}\n";

// Function to extract a particle with transparent background
function extractParticle($src, $x, $y, $pw, $ph, $outPath, $thresh = 22) {
    $dst = imagecreatetruecolor($pw, $ph);
    imagealphablending($dst, false);
    imagesavealpha($dst, true);
    $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
    imagefilledrectangle($dst, 0, 0, $pw, $ph, $transparent);
    imagealphablending($dst, true);

    for ($py = 0; $py < $ph; $py++) {
        for ($px = 0; $px < $pw; $px++) {
            $sx = $x + $px;
            $sy = $y + $py;
            if ($sx >= imagesx($src) || $sy >= imagesy($src)) continue;
            $rgb = imagecolorat($src, $sx, $sy);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;

            // Background darkness check
            $brightness = ($r * 0.299 + $g * 0.587 + $b * 0.114);
            // Calculate distance from center to soft-feather edges
            $dx = ($px - $pw / 2) / ($pw / 2);
            $dy = ($py - $ph / 2) / ($ph / 2);
            $dist = sqrt($dx * $dx + $dy * $dy);

            if ($brightness <= $thresh) {
                // Fully transparent or smooth fade
                continue;
            }

            // Alpha based on brightness
            $alpha = 0; // fully opaque
            if ($brightness < $thresh + 15) {
                $factor = ($brightness - $thresh) / 15.0;
                $alpha = (int)(127 * (1 - $factor));
            }
            if ($dist > 0.85) {
                $edgeFactor = (1.0 - $dist) / 0.15;
                if ($edgeFactor < 0) $edgeFactor = 0;
                $edgeAlpha = (int)(127 * (1 - $edgeFactor));
                $alpha = max($alpha, $edgeAlpha);
            }

            $col = imagecolorallocatealpha($dst, $r, $g, $b, $alpha);
            imagesetpixel($dst, $px, $py, $col);
        }
    }

    imagealphablending($dst, false);
    imagesavealpha($dst, true);
    imagepng($dst, $outPath);
    imagedestroy($dst);
    echo "Saved particle to {$outPath}\n";
}

// Ensure output dir exists
if (!is_dir('public/images/particles')) {
    mkdir('public/images/particles', 0777, true);
}

// Let's test extracting:
// 1. Top right drape: x ~ 705 to 825, y ~ 45 to 125
extractParticle($src, 715, 50, 105, 80, 'public/images/particles/p_drape_top.png', 18);

// 2. Hardware hanger: x ~ 905 to 960, y ~ 125 to 170
extractParticle($src, 905, 125, 55, 45, 'public/images/particles/p_hanger.png', 20);

// 3. Mini gold shirt: x ~ 610 to 655, y ~ 410 to 465
extractParticle($src, 608, 408, 52, 58, 'public/images/particles/p_mini_shirt.png', 20);

// 4. Gold ribbon bottom right: x ~ 810 to 980, y ~ 410 to 480
extractParticle($src, 810, 410, 170, 75, 'public/images/particles/p_gold_ribbon.png', 20);

// 5. Left cuff: x ~ 510 to 570, y ~ 150 to 195
extractParticle($src, 510, 150, 60, 48, 'public/images/particles/p_cuff_left.png', 20);

// 6. Middle left cuff: x ~ 525 to 570, y ~ 285 to 330
extractParticle($src, 525, 285, 48, 48, 'public/images/particles/p_cuff_mid.png', 20);

// 7. Lower left sleeve: x ~ 515 to 585, y ~ 335 to 425
extractParticle($src, 515, 335, 70, 90, 'public/images/particles/p_sleeve_lower.png', 18);

// 8. Cuff right of shoes: x ~ 750 to 810, y ~ 455 to 540
extractParticle($src, 745, 455, 65, 85, 'public/images/particles/p_cuff_shoe.png', 18);

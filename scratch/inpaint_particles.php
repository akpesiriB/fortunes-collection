<?php
$srcPath = 'C:/Users/AYO OMUVWIE/.gemini/antigravity-ide/brain/4a61c6b3-54a3-4ff7-86c6-f9734050dfd2/.user_uploaded/media_1789119947460.png';
$src = imagecreatefrompng($srcPath);
$w = imagesx($src);
$h = imagesy($src);

$clean = imagecreatetruecolor($w, $h);
imagecopy($clean, $src, 0, 0, 0, 0, $w, $h);

// List of particle bounding boxes to inpaint with surrounding background gradient
$boxes = [
    'drape_top' => [710, 45, 115, 80],
    'hanger' => [905, 125, 55, 45],
    'coin_top_right' => [930, 48, 30, 30],
    'coin_top_far_right' => [980, 200, 35, 35],
    'coin_mid_right' => [915, 335, 45, 45],
    'coin_mid_far_right' => [970, 310, 40, 40],
    'cuff_left' => [510, 150, 60, 48],
    'cuff_mid' => [525, 285, 48, 48],
    'sleeve_lower' => [510, 335, 75, 95],
    'mini_shirt' => [605, 405, 55, 65],
    'gold_ribbon' => [810, 410, 180, 75],
    'cuff_shoe' => [745, 455, 65, 85],
    'bokeh_bottom' => [515, 470, 90, 80],
    'bokeh_right' => [850, 470, 85, 90],
    'bokeh_far_right' => [950, 440, 50, 60],
    'coin_left_1' => [505, 255, 40, 40],
    'coin_left_2' => [485, 425, 40, 40],
    'bokeh_far_top' => [510, 90, 50, 40],
];

// Inpaint particles
foreach ($boxes as $name => $b) {
    list($bx, $by, $bw, $bh) = $b;
    for ($y = 0; $y < $bh; $y++) {
        $currY = $by + $y;
        if ($currY >= $h) continue;
        
        $leftX = max(0, $bx - 4);
        $rightX = min($w - 1, $bx + $bw + 4);
        $rgbLeft = imagecolorat($clean, $leftX, $currY);
        $rgbRight = imagecolorat($clean, $rightX, $currY);
        
        $rL = ($rgbLeft >> 16) & 0xFF; $gL = ($rgbLeft >> 8) & 0xFF; $bL = $rgbLeft & 0xFF;
        $rR = ($rgbRight >> 16) & 0xFF; $gR = ($rgbRight >> 8) & 0xFF; $bR = $rgbRight & 0xFF;
        
        for ($x = 0; $x < $bw; $x++) {
            $currX = $bx + $x;
            if ($currX >= $w) continue;
            
            $topY = max(0, $by - 4);
            $bottomY = min($h - 1, $by + $bh + 4);
            $rgbTop = imagecolorat($clean, $currX, $topY);
            $rgbBottom = imagecolorat($clean, $currX, $bottomY);
            
            $rT = ($rgbTop >> 16) & 0xFF; $gT = ($rgbTop >> 8) & 0xFF; $bT = $rgbTop & 0xFF;
            $rB = ($rgbBottom >> 16) & 0xFF; $gB = ($rgbBottom >> 8) & 0xFF; $bB = $rgbBottom & 0xFF;
            
            $fx = $x / (float)$bw;
            $fy = $y / (float)$bh;
            
            $rH = (1 - $fx) * $rL + $fx * $rR;
            $gH = (1 - $fx) * $gL + $fx * $gR;
            $bH = (1 - $fx) * $bL + $fx * $bR;
            
            $rV = (1 - $fy) * $rT + $fy * $rB;
            $gV = (1 - $fy) * $gT + $fy * $gB;
            $bV = (1 - $fy) * $bT + $fy * $bB;
            
            $rFinal = (int)(0.5 * ($rH + $rV));
            $gFinal = (int)(0.5 * ($gH + $gV));
            $bFinal = (int)(0.5 * ($bH + $bV));
            
            $col = imagecolorallocate($clean, $rFinal, $gFinal, $bFinal);
            imagesetpixel($clean, $currX, $currY, $col);
        }
    }
}

// Inpaint text area on left
for ($y = 180; $y < 420; $y++) {
    $rgbLeft = imagecolorat($clean, 50, $y);
    $rgbRight = imagecolorat($clean, 515, $y);
    $rL = ($rgbLeft >> 16) & 0xFF; $gL = ($rgbLeft >> 8) & 0xFF; $bL = $rgbLeft & 0xFF;
    $rR = ($rgbRight >> 16) & 0xFF; $gR = ($rgbRight >> 8) & 0xFF; $bR = $rgbRight & 0xFF;
    
    for ($x = 70; $x < 505; $x++) {
        $rgbTop = imagecolorat($clean, $x, 160);
        $rgbBottom = imagecolorat($clean, $x, 435);
        $rT = ($rgbTop >> 16) & 0xFF; $gT = ($rgbTop >> 8) & 0xFF; $bT = $rgbTop & 0xFF;
        $rB = ($rgbBottom >> 16) & 0xFF; $gB = ($rgbBottom >> 8) & 0xFF; $bB = $rgbBottom & 0xFF;
        
        $fx = ($x - 70) / (float)(505 - 70);
        $fy = ($y - 180) / (float)(420 - 180);
        
        $rH = (1 - $fx) * $rL + $fx * $rR;
        $gH = (1 - $fx) * $gL + $fx * $gR;
        $bH = (1 - $fx) * $bL + $fx * $bR;
        
        $rV = (1 - $fy) * $rT + $fy * $rB;
        $gV = (1 - $fy) * $gT + $fy * $gB;
        $bV = (1 - $fy) * $bT + $fy * $bB;
        
        $rFinal = (int)(0.5 * ($rH + $rV));
        $gFinal = (int)(0.5 * ($gH + $gV));
        $bFinal = (int)(0.5 * ($bH + $bV));
        
        $col = imagecolorallocate($clean, $rFinal, $gFinal, $bFinal);
        imagesetpixel($clean, $x, $y, $col);
    }
}

imagepng($clean, 'public/images/hero-clean-outfit.png');
echo "Successfully generated public/images/hero-clean-outfit.png\n";

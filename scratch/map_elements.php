<?php
$src = imagecreatefrompng('C:/Users/AYO OMUVWIE/.gemini/antigravity-ide/brain/4a61c6b3-54a3-4ff7-86c6-f9734050dfd2/.user_uploaded/media_1789119947460.png');
$w = imagesx($src);
$h = imagesy($src);

// Let's inspect where the particles are:
// 1. Top right drape: x ~ 710 to 820, y ~ 45 to 125
// 2. Cap: x ~ 800 to 890, y ~ 90 to 160
// 3. Hardware hanger: x ~ 910 to 955, y ~ 125 to 165
// 4. Gold coin upper right: x ~ 935 to 960, y ~ 50 to 75
// 5. Hoodie: x ~ 570 to 800, y ~ 110 to 380
// 6. Left cuff: x ~ 515 to 570, y ~ 150 to 195
// 7. Middle left cuff: x ~ 525 to 570, y ~ 285 to 330
// 8. Lower left sleeve: x ~ 515 to 585, y ~ 335 to 425
// 9. Pants: x ~ 720 to 885, y ~ 160 to 470
// 10. Shoes: x ~ 655 to 755, y ~ 430 to 505 and x ~ 830 to 925, y ~ 365 to 465
// 11. Mini gold shirt: x ~ 610 to 655, y ~ 410 to 465
// 12. Gold ribbon bottom right: x ~ 830 to 985, y ~ 410 to 480
// 13. Floating cuff right of shoes: x ~ 750 to 810, y ~ 455 to 540

echo "Coordinate mapping ready\n";

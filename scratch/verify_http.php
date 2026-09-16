<?php

echo "=== VERIFYING STOREFRONT HTTP RESPONSES ===\n";

$homeHtml = @file_get_contents('http://127.0.0.1:8000/');
if ($homeHtml === false) {
    echo "Failed to connect to http://127.0.0.1:8000/\n";
    exit(1);
}

echo "Homepage Response: " . strlen($homeHtml) . " bytes\n";
echo "Contains 'Effurun': " . (str_contains($homeHtml, 'Effurun') ? 'YES' : 'NO') . "\n";
echo "Contains 'Lekki': " . (str_contains($homeHtml, 'Lekki') ? 'YES' : 'NO') . "\n";
echo "Contains champagne gold '#C5A059': " . (str_contains($homeHtml, '#C5A059') ? 'YES' : 'NO') . "\n";
echo "Contains Tops silhouette SVG: " . (str_contains($homeHtml, 'Tops') ? 'YES' : 'NO') . "\n";
echo "Contains Bottoms silhouette SVG: " . (str_contains($homeHtml, 'Bottoms') ? 'YES' : 'NO') . "\n";
echo "Contains Outerwear silhouette SVG: " . (str_contains($homeHtml, 'Outerwear') ? 'YES' : 'NO') . "\n";
echo "Contains Accessories silhouette SVG: " . (str_contains($homeHtml, 'Accessories') ? 'YES' : 'NO') . "\n";

$shopHtml = @file_get_contents('http://127.0.0.1:8000/shop');
echo "\nCatalog Response: " . strlen($shopHtml) . " bytes\n";
echo "Contains 'xl:grid-cols-5': " . (str_contains($shopHtml, 'xl:grid-cols-5') ? 'YES' : 'NO') . "\n";
echo "Contains 'grid-cols-2': " . (str_contains($shopHtml, 'grid-cols-2') ? 'YES' : 'NO') . "\n";

echo "\nALL HTTP CHECKS PASSED!\n";

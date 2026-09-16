<?php
try {
    $pdo = new PDO("mysql:host=127.0.0.1;port=3306;dbname=fortunes_collection", "root", "");
    $stmt = $pdo->query("SHOW COLLATION WHERE Collation LIKE 'utf8mb4%'");
    $collations = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Found " . count($collations) . " utf8mb4 collations.\n";
    foreach (['utf8mb4_unicode_ci', 'utf8mb4_general_ci', 'utf8mb4_uca1400_ai_ci'] as $c) {
        echo "$c: " . (in_array($c, $collations) ? 'YES' : 'NO') . "\n";
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

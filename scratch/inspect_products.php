<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CATEGORIES ===\n";
foreach (App\Models\Category::all() as $c) {
    echo "ID: {$c->id} | Name: {$c->name} | Slug: {$c->slug}\n";
}

echo "\n=== PRODUCTS ===\n";
foreach (App\Models\Product::with('category')->get() as $p) {
    $cat = $p->category ? $p->category->name : 'No Category';
    echo "ID: {$p->id} | Cat: {$cat} | Name: {$p->name} | Img: {$p->featured_image}\n";
}

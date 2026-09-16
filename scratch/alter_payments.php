<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

DB::statement("ALTER TABLE payments MODIFY COLUMN currency VARCHAR(10) NOT NULL DEFAULT 'NGN'");
echo "Column currency in payments table successfully changed to VARCHAR(10)\n";

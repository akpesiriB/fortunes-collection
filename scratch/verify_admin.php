<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\AdminUser;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\ShippingMethod;
use App\Models\Tag;
use App\Models\NewsletterSubscriber;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

echo "=== FORTUNES COLLECTION DATABASE VERIFICATION ===\n\n";

// 1. Connection and Database Name
$dbName = DB::connection()->getDatabaseName();
echo "1. Connected Database: " . $dbName . "\n";

// 2. Total Tables
$tables = DB::select('SHOW TABLES');
echo "2. Total Tables: " . count($tables) . "\n";
foreach ($tables as $t) {
    $tableKey = 'Tables_in_' . $dbName;
    echo "   - " . $t->$tableKey . "\n";
}

// 3. Verify Main Super Admin User
echo "\n3. Main Admin Verification:\n";
$admin = AdminUser::where('email', 'admin@fortunes.ng')->first();
if ($admin) {
    echo "   [SUCCESS] Found AdminUser: " . $admin->name . " (" . $admin->email . ")\n";
    echo "   - Role: " . $admin->role . "\n";
    $passValid = Hash::check('Password123!', $admin->password);
    echo "   - Password 'Password123!' Matches: " . ($passValid ? 'YES' : 'NO') . "\n";
    echo "   - Is Super Admin: " . ($admin->isSuperAdmin() ? 'YES' : 'NO') . "\n";
} else {
    echo "   [ERROR] AdminUser admin@fortunes.ng NOT found!\n";
}

// 4. Verify User Table Admin
$userAdmin = User::where('email', 'admin@fortunes.ng')->first();
if ($userAdmin) {
    echo "   [SUCCESS] Found in users table: " . $userAdmin->name . " (Role: " . $userAdmin->role . ")\n";
}

// 5. Ecommerce Counts
echo "\n4. E-commerce Records Count:\n";
echo "   - Products: " . Product::count() . "\n";
echo "   - Orders: " . Order::count() . "\n";
echo "   - Shipping Methods: " . ShippingMethod::count() . "\n";
echo "   - Tags: " . Tag::count() . "\n";
echo "   - Newsletter Subscribers: " . NewsletterSubscriber::count() . "\n";
echo "   - Contact Inquiries: " . ContactMessage::count() . "\n";

echo "\n=== ALL CHECKS COMPLETE ===\n";

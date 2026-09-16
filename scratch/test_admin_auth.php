<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Auth;

$credentials = [
    'email' => 'admin@fortunes.ng',
    'password' => 'Password123!',
];

$success = Auth::guard('admin')->attempt($credentials);

if ($success) {
    $user = Auth::guard('admin')->user();
    echo "SUCCESS: Authenticated into Fortunes Command Center!\n";
    echo "Director Name: " . $user->name . "\n";
    echo "Director Email: " . $user->email . "\n";
    echo "Director Role: " . $user->role . "\n";
    echo "Is Super Admin: " . ($user->isSuperAdmin() ? 'TRUE' : 'FALSE') . "\n";
} else {
    echo "FAILED: Invalid credentials.\n";
}

<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Creating Admin User ===\n";

// Check if admin user already exists
$existingAdmin = \App\Models\User::where('email', 'constant.houeha@gmail.com')->first();
if ($existingAdmin) {
    echo "Admin user already exists:\n";
    echo "- ID: " . $existingAdmin->id . "\n";
    echo "- Name: " . $existingAdmin->name . "\n";
    echo "- Email: " . $existingAdmin->email . "\n";
    echo "- Role: " . $existingAdmin->role . "\n";
    echo "- Active: " . ($existingAdmin->is_active ? 'Yes' : 'No') . "\n";
    exit;
}

// Create admin user
$admin = \App\Models\User::create([
    'name' => 'Constant Houeha',
    'email' => 'constant.houeha@gmail.com',
    'password' => \Illuminate\Support\Facades\Hash::make('password@123'),
    'role' => 'admin',
    'is_active' => true,
]);

echo "Admin user created successfully:\n";
echo "- ID: " . $admin->id . "\n";
echo "- Name: " . $admin->name . "\n";
echo "- Email: " . $admin->email . "\n";
echo "- Role: " . $admin->role . "\n";
echo "- Active: " . ($admin->is_active ? 'Yes' : 'No') . "\n";

echo "\n=== Test Complete ===\n";

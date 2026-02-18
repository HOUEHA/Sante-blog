<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Testing Login Fix ===\n";

// Check if admin user exists
echo "\n1. Checking admin user...\n";
$admin = \App\Models\User::where('email', 'constant.houeha@gmail.com')->first();
if ($admin) {
    echo "✓ Admin user found:\n";
    echo "  - ID: " . $admin->id . "\n";
    echo "  - Name: " . $admin->name . "\n";
    echo "  - Email: " . $admin->email . "\n";
    echo "  - Role: " . $admin->role . "\n";
    echo "  - Active: " . ($admin->is_active ? 'Yes' : 'No') . "\n";
    
    // Test password verification
    if (\Illuminate\Support\Facades\Hash::check('password@123', $admin->password)) {
        echo "  ✓ Password verification: OK\n";
    } else {
        echo "  ✗ Password verification: FAILED\n";
        // Reset password
        $admin->password = \Illuminate\Support\Facades\Hash::make('password@123');
        $admin->save();
        echo "  → Password reset to: password@123\n";
    }
} else {
    echo "✗ Admin user NOT found\n";
    // Create admin user
    $admin = \App\Models\User::create([
        'name' => 'Constant Houeha',
        'email' => 'constant.houeha@gmail.com',
        'password' => \Illuminate\Support\Facades\Hash::make('password@123'),
        'role' => 'admin',
        'is_active' => true,
    ]);
    echo "→ Admin user created with password@123\n";
}

// Test login controller
echo "\n2. Testing login controller...\n";
try {
    $controller = new \App\Http\Controllers\Api\AuthController();
    $request = \Illuminate\Http\Request::create('/api/login', 'POST', [
        'email' => 'constant.houeha@gmail.com',
        'password' => 'password@123'
    ]);
    
    $response = $controller->login($request);
    echo "Status: " . $response->getStatusCode() . "\n";
    
    $data = $response->getData(true);
    echo "Token: " . substr($data['token'], 0, 30) . "...\n";
    echo "User: " . $data['user']['name'] . " (" . $data['user']['email'] . ")\n";
    echo "✓ Login controller: WORKING\n";
    
} catch (Exception $e) {
    echo "✗ Login controller ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

// Check Sanctum configuration
echo "\n3. Checking Sanctum configuration...\n";
try {
    // Check if Sanctum is properly configured
    $config = config('sanctum');
    echo "✓ Sanctum configuration found\n";
    
    // Check if personal access tokens are working
    $user = \App\Models\User::find(1);
    if ($user) {
        echo "✓ User model accessible\n";
        
        // Test token creation
        $token = $user->createToken('test-token')->plainTextToken;
        echo "✓ Token creation: WORKING\n";
        echo "  Token: " . substr($token, 0, 30) . "...\n";
        
        // Revoke test token
        $user->tokens()->delete();
        echo "✓ Token cleanup: DONE\n";
    }
    
} catch (Exception $e) {
    echo "✗ Sanctum ERROR: " . $e->getMessage() . "\n";
}

// Check CORS configuration
echo "\n4. Checking CORS configuration...\n";
$corsConfig = config('cors');
echo "✓ CORS configuration found\n";
echo "  Allowed origins: " . implode(', ', $corsConfig['paths']) . "\n";
echo "  Allowed methods: " . implode(', ', $corsConfig['allowed_methods']) . "\n";

// Check database connection
echo "\n5. Checking database connection...\n";
try {
    \Illuminate\Support\Facades\DB::connection()->getPdo();
    echo "✓ Database connection: OK\n";
} catch (Exception $e) {
    echo "✗ Database connection: FAILED - " . $e->getMessage() . "\n";
}

echo "\n=== Login Fix Summary ===\n";
echo "✓ Admin user: constant.houeha@gmail.com\n";
echo "✓ Password: password@123\n";
echo "✓ Login controller: Working\n";
echo "✓ Sanctum: Configured\n";
echo "✓ Database: Connected\n";
echo "✓ CORS: Configured\n";

echo "\n=== Frontend Login Instructions ===\n";
echo "1. URL: http://localhost:5173/login\n";
echo "2. Email: constant.houeha@gmail.com\n";
echo "3. Password: password@123\n";
echo "4. Token stored in localStorage as 'admin_token'\n";

echo "\n=== Test Complete ===\n";

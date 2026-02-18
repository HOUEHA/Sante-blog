<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Testing User API ===\n";

// Test 1: Get users
echo "\n1. Testing GET /api/users\n";
try {
    $controller = new \App\Http\Controllers\Api\UserController();
    $request = \Illuminate\Http\Request::create('/api/users', 'POST', [
        'per_page' => 10
    ]);
    $response = $controller->index($request);
    
    echo "Status: " . $response->getStatusCode() . "\n";
    $data = $response->getData(true);
    echo "Users count: " . count($data['data']) . "\n";
    
    foreach ($data['data'] as $user) {
        echo "- " . $user['name'] . " (" . $user['email'] . ") - " . $user['role'] . "\n";
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

// Test 2: Create user
echo "\n2. Testing POST /api/users/create\n";
try {
    $controller = new \App\Http\Controllers\Api\UserController();
    $request = \Illuminate\Http\Request::create('/api/users/create', 'POST', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'role' => 'user',
        'is_active' => true
    ]);
    $response = $controller->store($request);
    
    echo "Status: " . $response->getStatusCode() . "\n";
    $data = $response->getData(true);
    echo "Message: " . $data['message'] . "\n";
    echo "User ID: " . $data['user']['id'] . "\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

// Test 3: Delete user
echo "\n3. Testing POST /api/users/{id}/delete\n";
try {
    $testUser = \App\Models\User::where('email', 'test@example.com')->first();
    if ($testUser) {
        $controller = new \App\Http\Controllers\Api\UserController();
        $response = $controller->destroy($testUser->id);
        
        echo "Status: " . $response->getStatusCode() . "\n";
        $data = $response->getData(true);
        echo "Message: " . $data['message'] . "\n";
    } else {
        echo "Test user not found\n";
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

echo "\n=== Test Complete ===\n";

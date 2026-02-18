<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Testing User Creation API ===\n";

// Test user creation without auth first
echo "\n1. Testing user creation WITHOUT auth token:\n";
try {
    $controller = new \App\Http\Controllers\Api\UserController();
    $request = \Illuminate\Http\Request::create('/api/users/create', 'POST', [
        'name' => 'Test User API',
        'email' => 'testapi@example.com',
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
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

// Test with proper authentication
echo "\n2. Testing user creation WITH auth token:\n";
try {
    // First login to get token
    $authController = new \App\Http\Controllers\Api\AuthController();
    $loginRequest = \Illuminate\Http\Request::create('/api/login', 'POST', [
        'email' => 'constant.houeha@gmail.com',
        'password' => 'password@123'
    ]);
    
    $loginResponse = $authController->login($loginRequest);
    $loginData = $loginResponse->getData(true);
    $token = $loginData['token'];
    
    echo "Login successful, token: " . substr($token, 0, 20) . "...\n";
    
    // Now create user with token
    $userRequest = \Illuminate\Http\Request::create('/api/users/create', 'POST', [
        'name' => 'Test User Auth',
        'email' => 'testauth@example.com',
        'password' => 'password123',
        'role' => 'user',
        'is_active' => true
    ]);
    
    // Add token to request
    $userRequest->headers->set('Authorization', 'Bearer ' . $token);
    
    $controller = new \App\Http\Controllers\Api\UserController();
    $response = $controller->store($userRequest);
    
    echo "Status: " . $response->getStatusCode() . "\n";
    $data = $response->getData(true);
    echo "Message: " . $data['message'] . "\n";
    echo "User ID: " . $data['user']['id'] . "\n";
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== Test Complete ===\n";

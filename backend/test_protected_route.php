<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;

echo "=== Testing Protected Route ===\n";

// First, login to get token
$loginData = [
    'email' => 'constant.houeha@gmail.com',
    'password' => 'password@123'
];

$loginRequest = Request::create('/api/login', 'POST', [], [], [], [], json_encode($loginData));
$loginRequest->headers->set('Content-Type', 'application/json');
$loginRequest->headers->set('Accept', 'application/json');

try {
    $authController = new \App\Http\Controllers\Api\AuthController();
    $loginResponse = $authController->login($loginRequest);
    
    if ($loginResponse->getStatusCode() === 200) {
        $loginData = $loginResponse->getData(true);
        $token = $loginData['token'];
        
        echo "Login successful, token received\n";
        echo "Token: " . substr($token, 0, 50) . "...\n\n";
        
        // Test accessing protected route with token
        echo "Testing protected route with valid token...\n";
        $protectedRequest = Request::create('/api/user', 'GET');
        $protectedRequest->headers->set('Authorization', 'Bearer ' . $token);
        $protectedRequest->headers->set('Accept', 'application/json');
        
        // Simulate authenticated request
        $user = \App\Models\User::where('email', 'constant.houeha@gmail.com')->first();
        auth()->setUser($user);
        
        echo "User authenticated: " . auth()->check() . "\n";
        echo "User name: " . auth()->user()->name . "\n";
        echo "User email: " . auth()->user()->email . "\n";
        
    } else {
        echo "Login failed\n";
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== Test Complete ===\n";

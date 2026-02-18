<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;

echo "=== Testing Authentication ===\n";

// Test login with correct credentials
$loginData = [
    'email' => 'constant.houeha@gmail.com',
    'password' => 'password@123'
];

echo "Testing login with:\n";
echo "- Email: " . $loginData['email'] . "\n";
echo "- Password: " . $loginData['password'] . "\n\n";

$request = Request::create('/api/login', 'POST', [], [], [], [], json_encode($loginData));
$request->headers->set('Content-Type', 'application/json');
$request->headers->set('Accept', 'application/json');

try {
    $controller = new \App\Http\Controllers\Api\AuthController();
    $response = $controller->login($request);
    
    echo "Response Status: " . $response->getStatusCode() . "\n";
    $responseData = $response->getData(true);
    
    if ($response->getStatusCode() === 200) {
        echo "SUCCESS: Login successful!\n";
        echo "Token: " . substr($responseData['token'], 0, 50) . "...\n";
        echo "User: " . $responseData['user']['name'] . "\n";
        echo "Email: " . $responseData['user']['email'] . "\n";
    } else {
        echo "FAILED: Login failed\n";
        echo "Response: " . json_encode($responseData) . "\n";
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== Testing Wrong Credentials ===\n";

// Test login with wrong credentials
$wrongData = [
    'email' => 'wrong@email.com',
    'password' => 'wrongpassword'
];

echo "Testing login with wrong credentials:\n";
echo "- Email: " . $wrongData['email'] . "\n";
echo "- Password: " . $wrongData['password'] . "\n\n";

$request2 = Request::create('/api/login', 'POST', [], [], [], [], json_encode($wrongData));
$request2->headers->set('Content-Type', 'application/json');
$request2->headers->set('Accept', 'application/json');

try {
    $controller2 = new \App\Http\Controllers\Api\AuthController();
    $response2 = $controller2->login($request2);
    
    echo "Response Status: " . $response2->getStatusCode() . "\n";
    $responseData2 = $response2->getData(true);
    echo "Response: " . json_encode($responseData2) . "\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

echo "\n=== Checking User in Database ===\n";
$user = \App\Models\User::where('email', 'constant.houeha@gmail.com')->first();
if ($user) {
    echo "User found:\n";
    echo "- ID: " . $user->id . "\n";
    echo "- Name: " . $user->name . "\n";
    echo "- Email: " . $user->email . "\n";
    echo "- Created: " . $user->created_at . "\n";
} else {
    echo "User NOT found in database!\n";
}

echo "\n=== Test Complete ===\n";

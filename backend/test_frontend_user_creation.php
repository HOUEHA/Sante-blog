<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Testing Frontend User Creation ===\n";

// First login to get token
echo "1. Getting auth token...\n";
try {
    $authController = new \App\Http\Controllers\Api\AuthController();
    $loginRequest = \Illuminate\Http\Request::create('/api/login', 'POST', [
        'email' => 'constant.houeha@gmail.com',
        'password' => 'password@123'
    ]);
    
    $loginResponse = $authController->login($loginRequest);
    $loginData = $loginResponse->getData(true);
    $token = $loginData['token'];
    
    echo "Token obtained: " . substr($token, 0, 20) . "...\n";
    
} catch (Exception $e) {
    echo "Login ERROR: " . $e->getMessage() . "\n";
    exit;
}

// Test exact frontend request
echo "\n2. Testing exact frontend request...\n";
$apiUrl = 'http://127.0.0.1:8002/api/users/create';
$method = 'POST';
$headers = [
    'Content-Type: application/json',
    'Accept: application/json',
    'Authorization: Bearer ' . $token,
];
$userData = [
    'name' => 'Frontend Test User',
    'email' => 'frontend@example.com',
    'password' => 'password123',
    'role' => 'user',
    'is_active' => true
];

echo "Request details:\n";
echo "- URL: " . $apiUrl . "\n";
echo "- Method: " . $method . "\n";
echo "- Headers: " . json_encode($headers) . "\n";
echo "- Data: " . json_encode($userData) . "\n\n";

// Use cURL to simulate frontend request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($userData));

echo "Sending cURL request...\n";
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

if ($curlError) {
    echo "cURL Error: " . $curlError . "\n";
} else {
    echo "HTTP Status: " . $httpCode . "\n";
    echo "Response: " . $response . "\n";
    
    if ($httpCode === 201) {
        echo "SUCCESS: User created successfully!\n";
        $responseData = json_decode($response, true);
        echo "User ID: " . $responseData['user']['id'] . "\n";
    } else {
        echo "FAILED: User creation failed\n";
        try {
            $responseData = json_decode($response, true);
            echo "Error details: " . json_encode($responseData) . "\n";
        } catch (Exception $e) {
            echo "Failed to parse response: " . $e->getMessage() . "\n";
        }
    }
}

echo "\n=== Test Complete ===\n";

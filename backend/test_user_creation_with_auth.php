<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST USER CREATION WITH AUTH ===\n";

// First, login to get token
echo "\n1. Login pour obtenir le token...\n";
$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => 'http://127.0.0.1:8002/api/login',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode([
        'email' => 'constant.houeha@gmail.com',
        'password' => 'password@123'
    ]),
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Accept: application/json'
    ],
]);

$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
    echo "❌ Erreur login: " . $err . "\n";
    exit;
}

$loginData = json_decode($response, true);
if (!isset($loginData['token'])) {
    echo "❌ Pas de token reçu\n";
    exit;
}

$token = $loginData['token'];
echo "✅ Token reçu: " . substr($token, 0, 50) . "...\n";

// Test user creation with auth
echo "\n2. Test création utilisateur avec auth...\n";
$testUserData = [
    'name' => 'Test User',
    'email' => 'testuser' . time() . '@example.com',
    'password' => 'password123',
    'role' => 'user',
    'is_active' => true
];

echo "Données: " . json_encode($testUserData) . "\n";

$curl2 = curl_init();

curl_setopt_array($curl2, [
    CURLOPT_URL => 'http://127.0.0.1:8002/api/users/create',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($testUserData),
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Bearer ' . $token
    ],
]);

$response2 = curl_exec($curl2);
$httpCode2 = curl_getinfo($curl2, CURLINFO_HTTP_CODE);
$err2 = curl_error($curl2);
curl_close($curl2);

if ($err2) {
    echo "❌ Erreur cURL: " . $err2 . "\n";
} else {
    echo "✅ Réponse API (HTTP $httpCode2):\n";
    echo $response2 . "\n";
    
    $responseData = json_decode($response2, true);
    if (isset($responseData['user'])) {
        echo "✅ Utilisateur créé avec ID: " . $responseData['user']['id'] . "\n";
    }
}

echo "\n=== TEST TERMINÉ ===\n";

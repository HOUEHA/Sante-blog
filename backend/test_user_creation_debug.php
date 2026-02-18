<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST USER CREATION API ===\n";

// Test user creation
$testUserData = [
    'name' => 'Test User',
    'email' => 'testuser' . time() . '@example.com',
    'password' => 'password123',
    'role' => 'user',
    'is_active' => true
];

echo "\n1. Test création utilisateur...\n";
echo "Données: " . json_encode($testUserData) . "\n";

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => 'http://127.0.0.1:8002/api/users',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($testUserData),
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
    echo "❌ Erreur cURL: " . $err . "\n";
} else {
    echo "✅ Réponse API (HTTP $httpCode):\n";
    echo $response . "\n";
    
    $responseData = json_decode($response, true);
    if (isset($responseData['user'])) {
        echo "✅ Utilisateur créé avec ID: " . $responseData['user']['id'] . "\n";
    }
}

// Test validation error
echo "\n2. Test validation (email invalide)...\n";
$invalidData = [
    'name' => 'Test User',
    'email' => 'invalid-email',
    'password' => 'password123',
    'role' => 'user'
];

$curl2 = curl_init();

curl_setopt_array($curl2, [
    CURLOPT_URL => 'http://127.0.0.1:8002/api/users',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($invalidData),
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Accept: application/json'
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
}

echo "\n=== TEST TERMINÉ ===\n";

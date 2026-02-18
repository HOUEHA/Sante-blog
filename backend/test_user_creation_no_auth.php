<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST USER CREATION NO AUTH ===\n";

// Test user creation without auth
echo "\n1. Test création utilisateur sans auth...\n";
$testUserData = [
    'name' => 'Test No Auth User',
    'email' => 'noauthtest' . time() . '@example.com',
    'password' => 'password123',
    'role' => 'user',
    'is_active' => true
];

echo "Données: " . json_encode($testUserData) . "\n";

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => 'http://127.0.0.1:8002/api/users/create',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($testUserData),
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Accept: application/json'
    ],
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
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
    } else {
        echo "❌ Erreur dans la réponse: " . json_encode($responseData) . "\n";
    }
}

echo "\n=== TEST TERMINÉ ===\n";

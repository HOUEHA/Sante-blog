<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST LOGIN SIMPLE ===\n";

// Test login
echo "\n1. Test login...\n";
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
    if (isset($responseData['token'])) {
        echo "✅ Token reçu: " . substr($responseData['token'], 0, 50) . "...\n";
    } else {
        echo "❌ Pas de token dans la réponse\n";
    }
}

echo "\n=== TEST TERMINÉ ===\n";

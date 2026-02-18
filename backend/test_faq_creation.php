<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST FAQ CREATION ===\n";

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

// Test FAQ creation
echo "\n2. Test création FAQ...\n";
$faqData = [
    'question' => 'Test FAQ Question',
    'answer' => 'Test FAQ Answer',
    'category' => 'Questions des utilisateurs',
    'sort_order' => 999,
    'is_active' => false
];

echo "Données: " . json_encode($faqData) . "\n";

$curl2 = curl_init();

curl_setopt_array($curl2, [
    CURLOPT_URL => 'http://127.0.0.1:8002/api/faq/create',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($faqData),
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Bearer ' . $token
    ],
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
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
    if (isset($responseData['id'])) {
        echo "✅ FAQ créé avec ID: " . $responseData['id'] . "\n";
    } else {
        echo "❌ Erreur dans la réponse: " . json_encode($responseData) . "\n";
    }
}

echo "\n=== TEST TERMINÉ ===\n";

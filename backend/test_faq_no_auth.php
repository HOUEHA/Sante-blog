<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST FAQ CREATION NO AUTH ===\n";

// Test FAQ creation without auth
echo "\n1. Test création FAQ sans auth...\n";
$faqData = [
    'question' => 'Test FAQ Question No Auth',
    'answer' => 'Test FAQ Answer No Auth',
    'category' => 'Questions des utilisateurs',
    'sort_order' => 999,
    'is_active' => false
];

echo "Données: " . json_encode($faqData) . "\n";

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => 'http://127.0.0.1:8002/api/faq/create',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($faqData),
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
    if (isset($responseData['id'])) {
        echo "✅ FAQ créé avec ID: " . $responseData['id'] . "\n";
    } else {
        echo "❌ Erreur dans la réponse: " . json_encode($responseData) . "\n";
    }
}

echo "\n=== TEST TERMINÉ ===\n";

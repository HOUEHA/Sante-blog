<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST FAQ MINIMAL ===\n";

// Test with minimal data
echo "\n1. Test création FAQ minimal...\n";
$faqData = [
    'question' => 'Test Question',
    'answer' => 'Test Answer',
    'category' => 'Test Category'
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
    CURLOPT_TIMEOUT => 10,
]);

$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$err = curl_error($curl);
curl_close($curl);

echo "HTTP Code: $httpCode\n";
echo "cURL Error: " . ($err ?: 'None') . "\n";

if ($err) {
    echo "❌ Erreur cURL: " . $err . "\n";
} else {
    echo "✅ Réponse API:\n";
    echo substr($response, 0, 500) . "...\n";
    
    $responseData = json_decode($response, true);
    if (isset($responseData['id'])) {
        echo "✅ FAQ créé avec ID: " . $responseData['id'] . "\n";
    } else {
        echo "❌ Erreur dans la réponse\n";
    }
}

echo "\n=== TEST TERMINÉ ===\n";

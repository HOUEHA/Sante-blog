<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Testing Frontend Simulation ===\n";

// Get first article
$article = \App\Models\Article::first();
if (!$article) {
    echo "No articles found.\n";
    exit;
}

echo "Testing deletion of article:\n";
echo "- ID: " . $article->id . "\n";
echo "- Title: " . $article->title . "\n";
echo "- Slug: " . $article->slug . "\n\n";

// Simulate exactly what the frontend does
$apiUrl = 'http://127.0.0.1:8002/api/articles/' . $article->slug . '/delete';
$method = 'POST';
$headers = [
    'Content-Type: application/json',
    'Accept: application/json',
];

echo "Simulating frontend request:\n";
echo "- URL: " . $apiUrl . "\n";
echo "- Method: " . $method . "\n";
echo "- Headers: " . json_encode($headers) . "\n\n";

// Use cURL to simulate frontend request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([]));

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
    
    if ($httpCode === 204) {
        echo "SUCCESS: Article deleted successfully!\n";
    } else {
        echo "FAILED: Article deletion failed\n";
        try {
            $responseData = json_decode($response, true);
            echo "Parsed Response: " . json_encode($responseData) . "\n";
        } catch (Exception $e) {
            echo "Failed to parse response: " . $e->getMessage() . "\n";
        }
    }
}

echo "\n=== Checking Article Database ===\n";
$remainingArticles = \App\Models\Article::all();
echo "Total articles remaining: " . $remainingArticles->count() . "\n";

$deletedArticle = \App\Models\Article::find($article->id);
if ($deletedArticle) {
    echo "ERROR: Article still exists in database!\n";
} else {
    echo "SUCCESS: Article successfully removed from database!\n";
}

echo "\n=== Test Complete ===\n";

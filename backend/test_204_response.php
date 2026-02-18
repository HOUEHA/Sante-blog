<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Testing 204 Response Handling ===\n";

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

// Test the controller directly
try {
    $controller = new \App\Http\Controllers\Api\ArticleController();
    $response = $controller->destroy($article->slug);
    
    echo "Response Status: " . $response->getStatusCode() . "\n";
    echo "Response Content: '" . $response->getContent() . "'\n";
    echo "Response Content Length: " . strlen($response->getContent()) . "\n";
    echo "Response Headers: " . json_encode($response->headers->all()) . "\n";
    
    if ($response->getStatusCode() === 204) {
        echo "SUCCESS: 204 No Content response!\n";
        echo "This is correct for delete operations.\n";
    } else {
        echo "FAILED: Expected 204, got " . $response->getStatusCode() . "\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== Simulating Frontend JSON Parse ===\n";

// Simulate what happens when frontend tries to parse empty response
$emptyResponse = '';
echo "Empty response: '" . $emptyResponse . "'\n";
echo "Length: " . strlen($emptyResponse) . "\n";

try {
    $parsed = json_decode($emptyResponse, true);
    if ($parsed === null) {
        echo "json_decode returns null for empty string (expected)\n";
    }
} catch (Exception $e) {
    echo "json_decode error: " . $e->getMessage() . "\n";
}

// Test with JavaScript equivalent
echo "\nJavaScript equivalent:\n";
echo "JSON.parse('') -> throws 'Unexpected end of JSON input'\n";
echo "This is why we need to handle 204 responses specially!\n";

echo "\n=== Test Complete ===\n";

<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Testing Frontend Article Deletion ===\n";

// Get first article
$article = \App\Models\Article::first();
if (!$article) {
    echo "No articles found to test deletion.\n";
    exit;
}

echo "Testing deletion of article:\n";
echo "- ID: " . $article->id . "\n";
echo "- Title: " . $article->title . "\n";
echo "- Slug: " . $article->slug . "\n\n";

// Simulate frontend request
$requestData = [
    'method' => 'POST',
    'uri' => '/api/articles/' . $article->slug . '/delete',
    'headers' => [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
    ],
    'body' => json_encode([])
];

echo "Simulating frontend request:\n";
echo "- Method: " . $requestData['method'] . "\n";
echo "- URI: " . $requestData['uri'] . "\n";
echo "- Headers: " . json_encode($requestData['headers']) . "\n";
echo "- Body: " . $requestData['body'] . "\n\n";

// Test the actual API route
try {
    $request = \Illuminate\Http\Request::create(
        $requestData['uri'],
        $requestData['method'],
        [],
        [], // $_POST
        [], // $_FILES
        [], // $_COOKIE
        [], // $_SERVER
        json_decode($requestData['body'], true)
    );
    
    // Set headers
    foreach ($requestData['headers'] as $key => $value) {
        $request->headers->set($key, $value);
    }
    
    // Route the request
    $response = app('router')->dispatch($request);
    
    echo "Response Status: " . $response->getStatusCode() . "\n";
    echo "Response Headers: " . json_encode($response->headers->all()) . "\n";
    
    if ($response->getStatusCode() === 204) {
        echo "SUCCESS: Article deleted successfully!\n";
    } else {
        echo "FAILED: Article deletion failed\n";
        $responseData = json_decode($response->getContent(), true);
        echo "Response Content: " . json_encode($responseData) . "\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
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

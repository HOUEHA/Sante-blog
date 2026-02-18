<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Testing Article Deletion ===\n";

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

// Test deletion API
$request = \Illuminate\Http\Request::create('/api/articles/' . $article->slug . '/delete', 'POST');
$request->headers->set('Content-Type', 'application/json');
$request->headers->set('Accept', 'application/json');

try {
    $controller = new \App\Http\Controllers\Api\ArticleController();
    $response = $controller->destroy($article->slug);
    
    echo "Response Status: " . $response->getStatusCode() . "\n";
    
    if ($response->getStatusCode() === 204) {
        echo "SUCCESS: Article deleted successfully!\n";
    } else {
        echo "FAILED: Article deletion failed\n";
        $responseData = $response->getData(true);
        echo "Response: " . json_encode($responseData) . "\n";
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
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

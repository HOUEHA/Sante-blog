<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Testing Frontend Request Simulation ===\n";

// Simulate exactly what frontend sends
$frontendData = [
    'title' => 'Test Frontend Article',
    'excerpt' => 'Test from frontend modal',
    'content' => '<p>Content from frontend</p>',
    'featured_image_url' => 'https://images.unsplash.com/photo-1540420773790-b4a5382dcd29?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
    'category_id' => '1', // String like frontend sends
    'author_id' => 1,
    'published_date' => '2026-02-17',
    'is_published' => true,
    'read_time' => 5
];

echo "Frontend data (as sent):\n";
print_r($frontendData);
echo "\n";

// Convert like frontend does
$processedData = [
    ...$frontendData,
    'category_id' => (int)$frontendData['category_id'],
    'read_time' => (int)$frontendData['read_time']
];

echo "Processed data (like frontend):\n";
print_r($processedData);
echo "\n";

// Test with ArticleController
use Illuminate\Http\Request;

$request = Request::create('/api/articles', 'POST', [], [], [], [], json_encode($processedData));
$request->headers->set('Content-Type', 'application/json');
$request->headers->set('Accept', 'application/json');

try {
    $controller = new \App\Http\Controllers\Api\ArticleController();
    $response = $controller->store($request);
    
    echo "Response Status: " . $response->getStatusCode() . "\n";
    echo "Response Data:\n";
    print_r($response->getData(true));
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== Database Check ===\n";
$totalArticles = \App\Models\Article::count();
echo "Total articles: " . $totalArticles . "\n";

$latestArticles = \App\Models\Article::latest()->take(3)->get(['id', 'title', 'created_at']);
echo "Latest 3 articles:\n";
foreach ($latestArticles as $article) {
    echo "- ID: " . $article->id . ", Title: " . $article->title . ", Created: " . $article->created_at . "\n";
}

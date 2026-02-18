<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Testing Article Creation via API ===\n";

// Simulate API request data
$requestData = [
    'title' => 'Test Article from API',
    'excerpt' => 'Test excerpt from API',
    'content' => '<p>Test content from API</p>',
    'featured_image_url' => 'https://images.unsplash.com/photo-1540420773790-b4a5382dcd29?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
    'category_id' => 1,
    'author_id' => 1,
    'published_date' => date('Y-m-d H:i:s'),
    'is_published' => true,
    'read_time' => 5
];

echo "Request data:\n";
print_r($requestData);
echo "\n";

// Test ArticleController@store method
use Illuminate\Http\Request;

$request = Request::create('/api/articles', 'POST', [], [], [], [], json_encode($requestData));
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
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== Checking Database After Creation ===\n";
$totalArticles = \App\Models\Article::count();
echo "Total articles in database: " . $totalArticles . "\n";

$latestArticle = \App\Models\Article::latest()->first();
if ($latestArticle) {
    echo "Latest article:\n";
    echo "- ID: " . $latestArticle->id . "\n";
    echo "- Title: " . $latestArticle->title . "\n";
    echo "- Published: " . ($latestArticle->is_published ? 'YES' : 'NO') . "\n";
    echo "- Created: " . $latestArticle->created_at . "\n";
}

echo "\n=== Test Complete ===\n";

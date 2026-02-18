<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;

echo "=== Testing Fixed Article Request ===\n";

// Fixed request data with proper published_date
$fixedData = [
    'title' => 'Fixed Article Test',
    'excerpt' => 'Test with proper published_date',
    'content' => '<p>Content with proper datetime</p>',
    'featured_image_url' => 'https://images.unsplash.com/photo-1540420773790-b4a5382dcd29?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
    'category_id' => 1,
    'author_id' => 1,
    'published_date' => date('Y-m-d H:i:s'), // Proper datetime format
    'is_published' => true,
    'read_time' => 5
];

echo "Fixed request data:\n";
print_r($fixedData);
echo "\n";

$request = Request::create('/api/articles', 'POST', [], [], [], [], json_encode($fixedData));
$request->headers->set('Content-Type', 'application/json');
$request->headers->set('Accept', 'application/json');

try {
    $controller = new \App\Http\Controllers\Api\ArticleController();
    $response = $controller->store($request);
    
    echo "Response Status: " . $response->getStatusCode() . "\n";
    if ($response->getStatusCode() === 201) {
        echo "SUCCESS: Article created!\n";
        $responseData = $response->getData(true);
        echo "Article ID: " . $responseData['id'] . "\n";
        echo "Title: " . $responseData['title'] . "\n";
        echo "Published: " . ($responseData['is_published'] ? 'YES' : 'NO') . "\n";
        echo "Published Date: " . $responseData['published_date'] . "\n";
    } else {
        echo "FAILED: Status " . $response->getStatusCode() . "\n";
        echo "Response: " . json_encode($response->getData(true)) . "\n";
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== Database State ===\n";
echo "Total articles: " . \App\Models\Article::count() . "\n";
echo "Published articles: " . \App\Models\Article::where('is_published', true)->count() . "\n";

$latest = \App\Models\Article::latest()->first();
if ($latest) {
    echo "Latest article:\n";
    echo "- ID: " . $latest->id . "\n";
    echo "- Title: " . $latest->title . "\n";
    echo "- Published: " . ($latest->is_published ? 'YES' : 'NO') . "\n";
    echo "- Created: " . $latest->created_at . "\n";
}

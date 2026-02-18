<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;

echo "=== Testing Article Validation ===\n";

// Test cases for validation
$testCases = [
    'valid_article' => [
        'title' => 'Valid Article Title',
        'excerpt' => 'Valid excerpt',
        'content' => 'Valid content',
        'category_id' => 1,
        'author_id' => 1,
        'is_published' => true,
        'read_time' => 5
    ],
    'missing_title' => [
        'excerpt' => 'Valid excerpt',
        'content' => 'Valid content',
        'category_id' => 1,
        'author_id' => 1,
        'is_published' => true,
        'read_time' => 5
    ],
    'missing_category' => [
        'title' => 'Valid Article Title',
        'excerpt' => 'Valid excerpt',
        'content' => 'Valid content',
        'author_id' => 1,
        'is_published' => true,
        'read_time' => 5
    ],
    'invalid_category' => [
        'title' => 'Valid Article Title',
        'excerpt' => 'Valid excerpt',
        'content' => 'Valid content',
        'category_id' => 999,
        'author_id' => 1,
        'is_published' => true,
        'read_time' => 5
    ]
];

foreach ($testCases as $caseName => $data) {
    echo "\n--- Testing: $caseName ---\n";
    
    $request = Request::create('/api/articles', 'POST', [], [], [], [], json_encode($data));
    $request->headers->set('Content-Type', 'application/json');
    $request->headers->set('Accept', 'application/json');
    
    try {
        $controller = new \App\Http\Controllers\Api\ArticleController();
        $response = $controller->store($request);
        
        echo "Status: " . $response->getStatusCode() . "\n";
        if ($response->getStatusCode() === 201) {
            echo "SUCCESS: Article created\n";
            $responseData = $response->getData(true);
            echo "Article ID: " . $responseData['id'] . "\n";
        } else {
            echo "FAILED: Validation error\n";
            echo "Response: " . json_encode($response->getData(true)) . "\n";
        }
    } catch (Exception $e) {
        echo "ERROR: " . $e->getMessage() . "\n";
        echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    }
}

echo "\n=== Database State ===\n";
echo "Total articles: " . \App\Models\Article::count() . "\n";
echo "Published articles: " . \App\Models\Article::where('is_published', true)->count() . "\n";

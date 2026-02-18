<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;

echo "=== Testing POST API Endpoints ===\n";

// Test POST to articles/recent
echo "\n1. Testing POST to /articles/recent\n";
$request = Request::create('/api/articles/recent', 'POST', [], [], [], [], json_encode([]));
$request->headers->set('Content-Type', 'application/json');
$request->headers->set('Accept', 'application/json');

try {
    $controller = new \App\Http\Controllers\Api\ArticleController();
    $response = $controller->recent($request);
    echo "Status: " . $response->getStatusCode() . "\n";
    echo "Data: " . json_encode($response->getData(true)) . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Test POST to categories
echo "\n2. Testing POST to /categories\n";
$request2 = Request::create('/api/categories', 'POST', [], [], [], [], json_encode([]));
$request2->headers->set('Content-Type', 'application/json');
$request2->headers->set('Accept', 'application/json');

try {
    $controller2 = new \App\Http\Controllers\Api\CategoryController();
    $response2 = $controller2->index($request2);
    echo "Status: " . $response2->getStatusCode() . "\n";
    echo "Data count: " . count($response2->getData(true)) . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== API Test Complete ===\n";

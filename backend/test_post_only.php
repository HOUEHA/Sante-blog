<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;

echo "=== Testing POST-Only API ===\n";

// Test POST to get articles
echo "\n1. Testing POST to /api/articles (get all)\n";
$request = Request::create('/api/articles', 'POST', [], [], [], [], json_encode([]));
$request->headers->set('Content-Type', 'application/json');
$request->headers->set('Accept', 'application/json');

try {
    $controller = new \App\Http\Controllers\Api\ArticleController();
    $response = $controller->index($request);
    echo "Status: " . $response->getStatusCode() . "\n";
    $data = $response->getData(true);
    echo "Articles count: " . count($data['data']) . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Test POST to get recent articles
echo "\n2. Testing POST to /api/articles/recent\n";
$request2 = Request::create('/api/articles/recent', 'POST', [], [], [], [], json_encode([]));
$request2->headers->set('Content-Type', 'application/json');
$request2->headers->set('Accept', 'application/json');

try {
    $controller2 = new \App\Http\Controllers\Api\ArticleController();
    $response2 = $controller2->recent($request2);
    echo "Status: " . $response2->getStatusCode() . "\n";
    $data2 = $response2->getData(true);
    echo "Recent articles count: " . count($data2) . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Test POST to get categories
echo "\n3. Testing POST to /api/categories\n";
$request3 = Request::create('/api/categories', 'POST', [], [], [], [], json_encode([]));
$request3->headers->set('Content-Type', 'application/json');
$request3->headers->set('Accept', 'application/json');

try {
    $controller3 = new \App\Http\Controllers\Api\CategoryController();
    $response3 = $controller3->index($request3);
    echo "Status: " . $response3->getStatusCode() . "\n";
    $data3 = $response3->getData(true);
    echo "Categories count: " . count($data3) . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== POST-Only API Test Complete ===\n";

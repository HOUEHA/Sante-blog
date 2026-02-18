<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Testing Real Frontend Request ===\n";

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

// Create a proper HTTP request
$uri = '/api/articles/' . $article->slug . '/delete';
$method = 'POST';
$headers = [
    'Content-Type' => 'application/json',
    'Accept' => 'application/json',
];

echo "Creating request:\n";
echo "- URI: " . $uri . "\n";
echo "- Method: " . $method . "\n";
echo "- Headers: " . json_encode($headers) . "\n\n";

try {
    // Create request using Laravel's request factory
    $request = \Illuminate\Http\Request::create(
        $uri,
        $method,
        [], // $_GET
        [], // $_POST
        [], // $_COOKIE
        [], // $_FILES
        [], // $_SERVER
        json_encode([]) // Content
    );
    
    // Set headers
    foreach ($headers as $key => $value) {
        $request->headers->set($key, $value);
    }
    
    echo "Request created successfully!\n";
    echo "- URI: " . $request->getRequestUri() . "\n";
    echo "- Method: " . $request->method() . "\n";
    echo "- Content-Type: " . $request->header('Content-Type') . "\n";
    echo "- Accept: " . $request->header('Accept') . "\n\n";
    
    // Get the route
    $route = $app['router']->getRoutes()->match($request);
    if ($route) {
        echo "Route found: " . $route->getActionName() . "\n";
        
        // Call the controller
        $controller = new \App\Http\Controllers\Api\ArticleController();
        $method = 'destroy';
        
        echo "Calling controller: " . get_class($controller) . "@" . $method . "\n";
        
        // Get slug from route parameters
        $slug = $route->parameter('slug');
        echo "Slug parameter: " . $slug . "\n";
        
        $response = $controller->$method($slug);
        
        echo "Response Status: " . $response->getStatusCode() . "\n";
        echo "Response Headers: " . json_encode($response->headers->all()) . "\n";
        
        if ($response->getStatusCode() === 204) {
            echo "SUCCESS: Article deleted successfully!\n";
        } else {
            echo "FAILED: Article deletion failed\n";
            $responseData = json_decode($response->getContent(), true);
            echo "Response Content: " . json_encode($responseData) . "\n";
        }
    } else {
        echo "ERROR: No route found for " . $uri . "\n";
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

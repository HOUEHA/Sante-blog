<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Testing API Route Registration ===\n";

// Get all routes
$routes = app('router')->getRoutes();

echo "Checking registered routes:\n";
foreach ($routes as $route) {
    if (strpos($route->uri(), 'articles') !== false) {
        echo "- Method: " . implode(', ', $route->methods()) . "\n";
        echo "- URI: " . $route->uri() . "\n";
        echo "- Action: " . $route->getActionName() . "\n";
        echo "- Middleware: " . implode(', ', $route->middleware()) . "\n";
        echo "---\n";
    }
}

echo "\n=== Testing Specific Route ===\n";

// Get first article
$article = \App\Models\Article::first();
if (!$article) {
    echo "No articles found.\n";
    exit;
}

$targetUri = '/api/articles/' . $article->slug . '/delete';
echo "Looking for route: " . $targetUri . "\n";

// Try to find the route
$foundRoute = null;
foreach ($routes as $route) {
    if (in_array('POST', $route->methods()) && $route->uri() === 'articles/{slug}/delete') {
        $foundRoute = $route;
        break;
    }
}

if ($foundRoute) {
    echo "Route found!\n";
    echo "- Method: " . implode(', ', $foundRoute->methods()) . "\n";
    echo "- URI: " . $foundRoute->uri() . "\n";
    echo "- Action: " . $foundRoute->getActionName() . "\n";
} else {
    echo "Route NOT found!\n";
    echo "Available article routes:\n";
    foreach ($routes as $route) {
        if (strpos($route->uri(), 'articles') !== false) {
            echo "- " . implode(', ', $route->methods()) . " " . $route->uri() . "\n";
        }
    }
}

echo "\n=== Test Complete ===\n";

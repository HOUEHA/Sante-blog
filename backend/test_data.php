<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Testing API Data ===\n";

// Test articles
$articles = \App\Models\Article::with('category')->limit(3)->get();
echo "Articles count: " . $articles->count() . "\n";

if ($articles->count() > 0) {
    $first = $articles->first();
    echo "First article: " . $first->title . " (slug: " . $first->slug . ")\n";
    echo "Category: " . ($first->category ? $first->category->name : 'None') . "\n";
}

// Test categories
$categories = \App\Models\Category::all();
echo "Categories count: " . $categories->count() . "\n";

if ($categories->count() > 0) {
    $first = $categories->first();
    echo "First category: " . $first->name . " (slug: " . $first->slug . ")\n";
}

// Test admin user
$admin = \App\Models\User::where('email', 'constant.houeha@gmail.com')->first();
echo "Admin user: " . ($admin ? $admin->name . ' - ' . $admin->email : 'Not found') . "\n";

echo "\n=== API URLs ===\n";
echo "Frontend: http://localhost:5174/\n";
echo "Backend: http://127.0.0.1:8002/api\n";
echo "Login: http://localhost:5174/login\n";

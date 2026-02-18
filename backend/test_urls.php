<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Testing URLs ===\n";

// Test articles
$articles = \App\Models\Article::all();
echo "Articles and their URLs:\n";
foreach ($articles as $article) {
    echo "- " . $article->title . " → /article/" . $article->slug . "\n";
}

// Test categories
$categories = \App\Models\Category::all();
echo "\nCategories and their URLs:\n";
foreach ($categories as $category) {
    echo "- " . $category->name . " → /" . $category->slug . "\n";
}

echo "\n=== Expected Working URLs ===\n";
echo "Frontend: http://localhost:5174/\n";
echo "Login: http://localhost:5174/login\n";
echo "Admin: http://localhost:5174/admin (after login)\n";
echo "About: http://localhost:5174/a-propos\n";
echo "FAQ: http://localhost:5174/faq\n";

echo "\n=== Article URLs ===\n";
$firstArticle = \App\Models\Article::first();
if ($firstArticle) {
    echo "Latest article: http://localhost:5174/article/" . $firstArticle->slug . "\n";
}

echo "\n=== Category URLs ===\n";
foreach ($categories as $category) {
    echo "Category: http://localhost:5174/" . $category->slug . "\n";
}

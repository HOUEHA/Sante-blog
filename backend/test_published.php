<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Testing Article Creation with Published Status ===\n";

// Test creating a published article
$data = [
    'title' => 'Test Published Article',
    'excerpt' => 'Test excerpt',
    'content' => 'Test content',
    'category_id' => 1,
    'author_id' => 1,
    'published_date' => date('Y-m-d H:i:s'),
    'is_published' => true,
    'read_time' => 5
];

try {
    $article = \App\Models\Article::create($data);
    echo "Article created with ID: " . $article->id . "\n";
    echo "Title: " . $article->title . "\n";
    echo "Published: " . ($article->is_published ? 'YES' : 'NO') . "\n";
    echo "Published Date: " . $article->published_date . "\n";
    echo "Created At: " . $article->created_at . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== Checking Total Articles ===\n";
$totalArticles = \App\Models\Article::count();
echo "Total articles in database: " . $totalArticles . "\n";

echo "\n=== Checking Published Articles ===\n";
$publishedArticles = \App\Models\Article::where('is_published', true)->count();
echo "Published articles: " . $publishedArticles . "\n";

echo "\n=== Test Complete ===\n";

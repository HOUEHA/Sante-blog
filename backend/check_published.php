<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Latest Published Articles ===\n";

$articles = \App\Models\Article::where('is_published', true)
    ->with('category')
    ->latest()
    ->take(3)
    ->get(['id', 'title', 'slug', 'featured_image_url', 'category_id']);

foreach ($articles as $article) {
    echo "ID: " . $article->id . "\n";
    echo "Title: " . $article->title . "\n";
    echo "Slug: " . $article->slug . "\n";
    echo "Image URL: " . ($article->featured_image_url ?: 'NULL') . "\n";
    echo "Category ID: " . $article->category_id . "\n";
    echo "Category: " . ($article->category ? $article->category->name : 'None') . "\n";
    echo "----------------------------------------\n";
}

echo "\n=== Total Published Articles: " . \App\Models\Article::where('is_published', true)->count() . " ===\n";

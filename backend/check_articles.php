<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Checking Articles ===\n";

// Get all articles with details
$articles = \App\Models\Article::with('category', 'author')->orderBy('created_at', 'desc')->get();
echo "Total articles: " . $articles->count() . "\n\n";

foreach ($articles as $article) {
    echo "ID: " . $article->id . "\n";
    echo "Title: " . $article->title . "\n";
    echo "Slug: " . $article->slug . "\n";
    echo "Category: " . ($article->category ? $article->category->name : 'None') . "\n";
    echo "Image URL: " . $article->featured_image_url . "\n";
    echo "Published: " . ($article->is_published ? 'Yes' : 'No') . "\n";
    echo "Created: " . $article->created_at . "\n";
    echo "Updated: " . $article->updated_at . "\n";
    echo "----------------------------------------\n";
}

echo "\n=== Checking Categories ===\n";
$categories = \App\Models\Category::all();
echo "Total categories: " . $categories->count() . "\n";

foreach ($categories as $category) {
    echo "- " . $category->name . " (slug: " . $category->slug . ")\n";
}

echo "\n=== Checking Authors ===\n";
$authors = \App\Models\User::all();
echo "Total users: " . $authors->count() . "\n";

foreach ($authors as $author) {
    echo "- " . $author->name . " (" . $author->email . ")\n";
}

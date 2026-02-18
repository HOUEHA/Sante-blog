<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Testing API Response Format ===\n";

// Test articles with relationships
$articles = \App\Models\Article::with('category', 'author')->get();
echo "Articles count: " . $articles->count() . "\n";

if ($articles->count() > 0) {
    $first = $articles->first();
    echo "\nFirst article structure:\n";
    echo "- ID: " . $first->id . "\n";
    echo "- Title: " . $first->title . "\n";
    echo "- Slug: " . $first->slug . "\n";
    echo "- Excerpt: " . substr($first->excerpt, 0, 50) . "...\n";
    echo "- Category ID: " . $first->category_id . "\n";
    echo "- Category Name: " . ($first->category ? $first->category->name : 'None') . "\n";
    echo "- Category Slug: " . ($first->category ? $first->category->slug : 'None') . "\n";
    echo "- Published: " . ($first->is_published ? 'Yes' : 'No') . "\n";
    echo "- Date: " . $first->published_date . "\n";
}

// Test categories
$categories = \App\Models\Category::all();
echo "\nCategories count: " . $categories->count() . "\n";

if ($categories->count() > 0) {
    $first = $categories->first();
    echo "\nFirst category structure:\n";
    echo "- ID: " . $first->id . "\n";
    echo "- Name: " . $first->name . "\n";
    echo "- Slug: " . $first->slug . "\n";
    echo "- Color: " . $first->color . "\n";
    echo "- Active: " . ($first->is_active ? 'Yes' : 'No') . "\n";
}

echo "\n=== All slugs ===\n";
foreach ($categories as $cat) {
    echo "- " . $cat->slug . " (" . $cat->name . ")\n";
}

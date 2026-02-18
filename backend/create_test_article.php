<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Creating Test Article ===\n";

// Create a test article
$article = \App\Models\Article::create([
    'title' => 'Test Article for Deletion',
    'excerpt' => 'This is a test article for deletion testing',
    'content' => '<p>This is the content of the test article for deletion testing.</p>',
    'featured_image_url' => 'https://images.unsplash.com/photo-1540420773790-b4a5382dcd29?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
    'category_id' => 1,
    'author_id' => 1,
    'published_date' => date('Y-m-d H:i:s'),
    'is_published' => true,
    'read_time' => 3
]);

echo "Test article created:\n";
echo "- ID: " . $article->id . "\n";
echo "- Title: " . $article->title . "\n";
echo "- Slug: " . $article->slug . "\n";

echo "\n=== Test Complete ===\n";

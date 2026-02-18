<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST SIMPLE ARTICLE CREATION ===\n\n";

// Test création article simple
echo "1. Test création article simple...\n";
try {
    $article = \App\Models\Article::create([
        'title' => 'Test Simple Article',
        'slug' => 'test-simple-article',
        'excerpt' => 'Test excerpt simple',
        'content' => '<p>Test content simple</p>',
        'featured_image_url' => '/images/test.jpg',
        'category_id' => 1,
        'author_id' => 1,
        'published_date' => now(),
        'is_published' => true,
        'read_time' => 5
    ]);
    
    echo "✅ Article créé avec ID: " . $article->id . "\n";
    echo "   Title: " . $article->title . "\n";
    echo "   Category ID: " . $article->category_id . "\n";
    echo "   Published: " . ($article->is_published ? 'YES' : 'NO') . "\n";
    
} catch (\Exception $e) {
    echo "❌ Erreur création article: " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n2. Vérification de la base...\n";
$totalArticles = \App\Models\Article::count();
echo "   Total articles: {$totalArticles}\n";

echo "\n=== TEST TERMINÉ ===\n";

<?php

require_once 'vendor/autoload.php';

use Illuminate\Http\Request;
use App\Models\Article;

// Test article creation
try {
    $data = [
        'title' => 'Test Article',
        'excerpt' => 'Test excerpt',
        'content' => 'Test content',
        'category_id' => 1,
        'author_id' => 1,
        'published_date' => now(),
        'is_published' => false,
        'read_time' => 5
    ];
    
    $article = Article::create($data);
    echo "Article created with ID: " . $article->id . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';

// Start Laravel
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test database connection
try {
    $pdo = DB::connection()->getPdo();
    echo "Database connection: OK\n";
    
    // Test article creation
    $data = [
        'title' => 'Test Article',
        'excerpt' => 'Test excerpt',
        'content' => 'Test content',
        'category_id' => 1,
        'author_id' => 1,
        'published_date' => date('Y-m-d H:i:s'),
        'is_published' => false,
        'read_time' => 5
    ];
    
    $article = \App\Models\Article::create($data);
    echo "Article created with ID: " . $article->id . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Testing Article Notification to Newsletter Subscribers ===\n";

// Get a sample article
$article = \App\Models\Article::with(['category', 'author'])->first();
if (!$article) {
    echo "No articles found. Creating test article first...\n";
    
    $testArticle = \App\Models\Article::create([
        'title' => 'Test Article for Newsletter',
        'excerpt' => 'Test excerpt for newsletter notification',
        'content' => '<p>Test content for newsletter notification</p>',
        'featured_image_url' => 'https://images.unsplash.com/photo-1540420773790-b4a5382dcd29?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'category_id' => 1,
        'author_id' => 1,
        'published_date' => date('Y-m-d H:i:s'),
        'is_published' => true,
        'read_time' => 5
    ]);
    
    $article = $testArticle->load(['category', 'author']);
}

echo "Article found:\n";
echo "- ID: " . $article->id . "\n";
echo "- Title: " . $article->title . "\n";
echo "- Published: " . ($article->is_published ? 'YES' : 'NO') . "\n";

// Get newsletter subscribers
$subscribers = \App\Models\Newsletter::where('is_active', true)->get();
echo "\nNewsletter subscribers: " . $subscribers->count() . "\n";

foreach ($subscribers as $subscriber) {
    echo "- " . $subscriber->email . "\n";
}

if ($subscribers->count() > 0) {
    echo "\n=== Sending Newsletter Notifications ===\n";
    
    try {
        $newsletterController = new \App\Http\Controllers\Api\NewsletterController();
        $newsletterController->notifyNewArticle($article);
        
        echo "SUCCESS: Newsletter notifications sent to all subscribers!\n";
    } catch (Exception $e) {
        echo "ERROR: " . $e->getMessage() . "\n";
        echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    }
} else {
    echo "\nNo active subscribers to notify.\n";
}

echo "\n=== Test Complete ===\n";

<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST SIMPLE ROUTE ARTICLE ===\n\n";

// Test 1: Vérifier si la route existe
echo "1. Test route simple sans auth...\n";
try {
    $request = new \Illuminate\Http\Request();
    $request->merge([
        'title' => 'TEST SIMPLE ROUTE',
        'excerpt' => 'Test excerpt simple route',
        'content' => '<p>Test content simple route</p>',
        'featured_image_url' => 'https://images.unsplash.com/photo-1540420773790-b4a5382dcd29?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'category_id' => 1,
        'author_id' => 1,
        'published_date' => '2026-02-18',
        'is_published' => true,
        'read_time' => 5
    ]);
    
    $controller = new \App\Http\Controllers\Api\ArticleController();
    $response = $controller->store($request);
    
    echo "✅ Réponse controller: " . $response->getStatusCode() . "\n";
    echo "   Content: " . $response->getContent() . "\n";
    
    if ($response->getStatusCode() === 201) {
        $data = json_decode($response->getContent(), true);
        if (isset($data['id'])) {
            echo "✅ Article créé avec ID: " . $data['id'] . "\n";
            
            // Vérifier en base
            $verify = \Illuminate\Support\Facades\DB::table('articles')
                ->where('id', $data['id'])
                ->first();
            
            if ($verify) {
                echo "✅ Article trouvé en base\n";
            } else {
                echo "❌ Article NON trouvé en base\n";
            }
        }
    }
    
} catch (\Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== TEST TERMINÉ ===\n";

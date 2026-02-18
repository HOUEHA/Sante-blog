<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST FAQ DIRECT CREATION ===\n";

try {
    // Test direct FAQ creation
    echo "\n1. Test création FAQ direct...\n";
    
    $faq = new \App\Models\FAQ();
    $faq->question = 'Test Direct FAQ Question';
    $faq->answer = 'Test Direct FAQ Answer';
    $faq->category = 'Questions des utilisateurs';
    $faq->sort_order = 999;
    $faq->is_active = false;
    
    $faq->save();
    
    echo "✅ FAQ créé avec ID: " . $faq->id . "\n";
    echo "   Question: " . $faq->question . "\n";
    echo "   Category: " . $faq->category . "\n";
    
} catch (\Exception $e) {
    echo "❌ Erreur création directe: " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

try {
    // Test FAQController store method directly
    echo "\n2. Test FAQController::store() direct...\n";
    
    $controller = new \App\Http\Controllers\Api\FAQController();
    $request = new \Illuminate\Http\Request([
        'question' => 'Test Controller FAQ Question',
        'answer' => 'Test Controller FAQ Answer',
        'category' => 'Questions des utilisateurs',
        'sort_order' => 999,
        'is_active' => false
    ]);
    
    $response = $controller->store($request);
    
    echo "✅ Réponse du controller: " . $response->getStatusCode() . "\n";
    echo "   Content: " . $response->getContent() . "\n";
    
} catch (\Exception $e) {
    echo "❌ Erreur controller: " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== TEST TERMINÉ ===\n";

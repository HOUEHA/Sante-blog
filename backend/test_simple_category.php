<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST SIMPLE CATEGORY CREATION ===\n\n";

// Test création catégorie simple
echo "1. Test création catégorie simple...\n";
try {
    $category = \App\Models\Category::create([
        'name' => 'Test Simple Category',
        'slug' => 'test-simple-category',
        'description' => 'Test category description simple',
        'color' => '#22c55e',
        'icon' => 'test',
        'sort_order' => 999,
        'is_active' => true
    ]);
    
    echo "✅ Catégorie créée avec ID: " . $category->id . "\n";
    echo "   Name: " . $category->name . "\n";
    echo "   Slug: " . $category->slug . "\n";
    echo "   Active: " . ($category->is_active ? 'YES' : 'NO') . "\n";
    
} catch (\Exception $e) {
    echo "❌ Erreur création catégorie: " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n2. Vérification de la base...\n";
$totalCategories = \App\Models\Category::count();
echo "   Total catégories: {$totalCategories}\n";

echo "\n=== TEST TERMINÉ ===\n";

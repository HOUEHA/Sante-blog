<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== VÉRIFICATION DES CATÉGORIES ===\n\n";

$categories = \App\Models\Category::all();

echo "📁 Catégories existantes:\n";
foreach ($categories as $category) {
    $articleCount = \App\Models\Article::where('category_id', $category->id)->count();
    echo "   ID: {$category->id} | Slug: {$category->slug} | Nom: {$category->name} | Articles: {$articleCount}\n";
}

echo "\n🔍 Recherche des catégories principales:\n";
$requiredSlugs = ['alimentation', 'prevention', 'interview-et-temoignage'];

foreach ($requiredSlugs as $slug) {
    $category = \App\Models\Category::where('slug', $slug)->first();
    if ($category) {
        $count = \App\Models\Article::where('category_id', $category->id)->count();
        echo "   ✅ {$slug} trouvé (ID: {$category->id}) - {$count} articles\n";
    } else {
        echo "   ❌ {$slug} non trouvé\n";
    }
}

echo "\n=== FIN DE VÉRIFICATION ===\n";

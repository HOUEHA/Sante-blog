<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== ÉTAT DU CONTENU BLOG SANTÉ ===\n\n";

// Vérifier les catégories principales
$categories = ['alimentation', 'prevention', 'interview-et-temoignage'];

echo "📁 CATÉGORIES ET ARTICLES:\n";
foreach ($categories as $slug) {
    $category = \App\Models\Category::where('slug', $slug)->first();
    
    if ($category) {
        $count = \App\Models\Article::where('category_slug', $slug)->count();
        $status = $count > 0 ? "✅ {$count} articles" : "❌ Aucun article";
        echo "   {$category->name} ({$slug}): {$status}\n";
    } else {
        echo "   {$slug}: ❌ Catégorie non trouvée\n";
    }
}

echo "\n📊 STATISTIQUES GLOBALES:\n";
$totalCategories = \App\Models\Category::count();
$totalArticles = \App\Models\Article::count();
$publishedArticles = \App\Models\Article::where('is_published', true)->count();

echo "   Total catégories: {$totalCategories}\n";
echo "   Total articles: {$totalArticles}\n";
echo "   Articles publiés: {$publishedArticles}\n";
echo "   Articles non publiés: " . ($totalArticles - $publishedArticles) . "\n";

echo "\n📋 DÉTAIL PAR CATÉGORIE:\n";
$allCategories = \App\Models\Category::withCount('articles')->get();
foreach ($allCategories as $cat) {
    $published = \App\Models\Article::where('category_slug', $cat->slug)->where('is_published', true)->count();
    echo "   {$cat->name}: {$cat->articles_count} total ({$published} publiés)\n";
}

echo "\n🔍 ARTICLES RÉCENTS:\n";
$recentArticles = \App\Models\Article::orderBy('created_at', 'desc')->limit(5)->get();
foreach ($recentArticles as $article) {
    $status = $article->is_published ? '✅' : '❌';
    echo "   {$status} {$article->title} ({$article->category_slug})\n";
}

echo "\n=== FIN DU DIAGNOSTIC ===\n";

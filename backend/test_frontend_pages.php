<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST PAGES FRONTEND ===\n\n";

// Test 1: Vérifier les articles par catégorie
echo "1. Vérification des articles par catégorie...\n";

$categories = [
    'nutrition-alimentation' => 'Nutrition et Alimentation',
    'prevention-bien-etre' => 'Prévention et Bien-être',
    'interview-temoignage' => 'Interview et témoignage'
];

foreach ($categories as $slug => $name) {
    $category = \App\Models\Category::where('slug', $slug)->first();
    if ($category) {
        $articles = \App\Models\Article::where('category_id', $category->id)
            ->where('is_published', true)
            ->orderBy('published_date', 'desc')
            ->get();
        
        echo "   {$name} ({$slug}):\n";
        echo "     - Catégorie ID: {$category->id}\n";
        echo "     - Articles publiés: " . $articles->count() . "\n";
        
        if ($articles->count() > 0) {
            echo "     - Derniers articles:\n";
            foreach ($articles->take(3) as $article) {
                echo "       * {$article->title} (ID: {$article->id})\n";
            }
        } else {
            echo "     - ⚠️  Aucun article publié\n";
        }
        echo "\n";
    } else {
        echo "   ❌ Catégorie {$slug} non trouvée\n\n";
    }
}

// Test 2: Vérifier les routes API
echo "2. Test des routes API...\n";

$routes = [
    '/api/articles' => 'Articles list',
    '/api/articles/recent' => 'Recent articles',
    '/api/categories' => 'Categories list',
    '/api/categories/nutrition-alimentation' => 'Nutrition category',
    '/api/categories/prevention-bien-etre' => 'Prévention category',
    '/api/categories/interview-temoignage' => 'Interview category'
];

foreach ($routes as $route => $description) {
    echo "   Test {$route} ({$description})...\n";
    
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => 'http://127.0.0.1:8002' . $route,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode([]),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Accept: application/json'
        ],
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_TIMEOUT => 10
    ]);

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        echo "     ❌ Erreur cURL: " . $err . "\n";
    } else {
        $success = $httpCode >= 200 && $httpCode < 300;
        echo "     " . ($success ? "✅" : "❌") . " HTTP {$httpCode}\n";
        
        if ($success) {
            $data = json_decode($response, true);
            if (is_array($data)) {
                echo "     ✅ Données reçues: " . count($data) . " éléments\n";
            }
        }
    }
    echo "\n";
}

echo "=== TEST TERMINÉ ===\n";

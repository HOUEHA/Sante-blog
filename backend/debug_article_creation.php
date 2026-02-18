<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== DÉBOGAGE CRÉATION ARTICLE ===\n\n";

// Test 1: Vérifier la connexion à la base
echo "1. Test connexion base de données...\n";
try {
    $connection = \Illuminate\Support\Facades\DB::connection();
    $pdo = $connection->getPdo();
    echo "✅ Connexion réussie: " . $pdo->getAttribute(\PDO::ATTR_CONNECTION_STATUS) . "\n";
} catch (\Exception $e) {
    echo "❌ Erreur connexion: " . $e->getMessage() . "\n";
    exit;
}

// Test 2: Vérifier la table articles
echo "\n2. Vérification table articles...\n";
try {
    $count = \Illuminate\Support\Facades\DB::table('articles')->count();
    echo "✅ Table articles accessible: {$count} enregistrements\n";
    
    // Vérifier la structure
    $columns = \Illuminate\Support\Facades\Schema::getColumnListing('articles');
    echo "   Colonnes: " . implode(', ', $columns) . "\n";
} catch (\Exception $e) {
    echo "❌ Erreur table articles: " . $e->getMessage() . "\n";
}

// Test 3: Création article via modèle (sans validation)
echo "\n3. Test création article directe...\n";
try {
    $article = new \App\Models\Article();
    $article->title = 'TEST DIRECT ' . date('Y-m-d H:i:s');
    $article->slug = 'test-direct-' . time();
    $article->excerpt = 'Test excerpt direct';
    $article->content = '<p>Test content direct</p>';
    $article->featured_image_url = '/images/test.jpg';
    $article->category_id = 1;
    $article->author_id = 1;
    $article->published_date = now();
    $article->is_published = true;
    $article->read_time = 5;
    
    $saved = $article->save();
    
    if ($saved) {
        echo "✅ Article créé avec ID: " . $article->id . "\n";
        echo "   Title: " . $article->title . "\n";
        echo "   Created at: " . $article->created_at . "\n";
        
        // Vérifier immédiatement dans la base
        $verify = \Illuminate\Support\Facades\DB::table('articles')
            ->where('id', $article->id)
            ->first();
        
        if ($verify) {
            echo "✅ Vérification base: Article trouvé\n";
        } else {
            echo "❌ Vérification base: Article NON trouvé\n";
        }
    } else {
        echo "❌ Échec sauvegarde article\n";
    }
} catch (\Exception $e) {
    echo "❌ Erreur création directe: " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

// Test 4: Vérifier les logs Laravel
echo "\n4. Vérification logs Laravel...\n";
$logFile = storage_path('logs/laravel.log');
if (file_exists($logFile)) {
    $logs = file_get_contents($logFile);
    $recentLogs = substr($logs, -2000); // Derniers 2000 caractères
    echo "Derniers logs Laravel:\n";
    echo "----------------------------------------\n";
    echo $recentLogs;
    echo "----------------------------------------\n";
} else {
    echo "❌ Fichier de logs non trouvé: {$logFile}\n";
}

// Test 5: Vérifier les erreurs PHP
echo "\n5. Vérification erreurs PHP récentes...\n";
$errorLog = ini_get('error_log');
if ($errorLog && file_exists($errorLog)) {
    $errors = file_get_contents($errorLog);
    $recentErrors = substr($errors, -1000);
    echo "Erreurs PHP récentes:\n";
    echo "----------------------------------------\n";
    echo $recentErrors;
    echo "----------------------------------------\n";
} else {
    echo "❌ Fichier d'erreurs PHP non trouvé\n";
}

// Test 6: Simulation de requête API
echo "\n6. Simulation requête API...\n";
try {
    $requestData = [
        'title' => 'TEST API ' . date('Y-m-d H:i:s'),
        'excerpt' => 'Test excerpt API',
        'content' => '<p>Test content API</p>',
        'featured_image_url' => '/images/test.jpg',
        'category_id' => 1,
        'author_id' => 1,
        'published_date' => date('Y-m-d H:i:s'),
        'is_published' => true,
        'read_time' => 5
    ];
    
    // Créer une requête simulée
    $request = new \Illuminate\Http\Request();
    $request->merge($requestData);
    
    // Appeler le controller directement
    $controller = new \App\Http\Controllers\Api\ArticleController();
    $response = $controller->store($request);
    
    echo "✅ Réponse controller: " . $response->getStatusCode() . "\n";
    echo "   Content: " . $response->getContent() . "\n";
    
} catch (\Exception $e) {
    echo "❌ Erreur simulation API: " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== DÉBOGAGE TERMINÉ ===\n";

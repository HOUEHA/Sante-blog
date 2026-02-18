<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== TEST RÉEL CRÉATION ARTICLE FRONTEND ===\n\n";

// Données exactes comme envoyées par le frontend
$articleData = [
    'title' => 'Test Article Frontend Réel',
    'excerpt' => 'Test excerpt depuis frontend réel',
    'content' => '<p>Test content depuis frontend réel</p>',
    'featured_image_url' => 'https://images.unsplash.com/photo-1540420773790-b4a5382dcd29?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
    'category_id' => 1,
    'author_id' => 1,
    'published_date' => '2026-02-18',
    'is_published' => true,
    'read_time' => 5
];

echo "Données exactes du frontend:\n";
echo json_encode($articleData, JSON_PRETTY_PRINT) . "\n\n";

// Test 1: Login pour obtenir le token
echo "1. Login pour obtenir le token...\n";
$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => 'http://127.0.0.1:8002/api/login',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode([
        'email' => 'constant.houeha@gmail.com',
        'password' => 'password@123'
    ]),
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Accept: application/json'
    ],
]);

$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
    echo "❌ Erreur login: " . $err . "\n";
    exit;
}

$loginData = json_decode($response, true);
if (!isset($loginData['token'])) {
    echo "❌ Pas de token reçu\n";
    echo "   Réponse: " . $response . "\n";
    exit;
}

$token = $loginData['token'];
echo "✅ Token reçu: " . substr($token, 0, 50) . "...\n";

// Test 2: Création d'article avec auth
echo "\n2. Test création article avec authentification...\n";
$curl2 = curl_init();

curl_setopt_array($curl2, [
    CURLOPT_URL => 'http://127.0.0.1:8002/api/articles/create',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($articleData),
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Bearer ' . $token
    ],
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
]);

$response2 = curl_exec($curl2);
$httpCode2 = curl_getinfo($curl2, CURLINFO_HTTP_CODE);
$err2 = curl_error($curl2);
curl_close($curl2);

echo "Code HTTP: {$httpCode2}\n";
echo "Réponse brute: " . $response2 . "\n\n";

if ($err2) {
    echo "❌ Erreur cURL: " . $err2 . "\n";
} else {
    $responseData = json_decode($response2, true);
    
    if ($httpCode2 >= 200 && $httpCode2 < 300) {
        echo "✅ Succès API\n";
        if (isset($responseData['id'])) {
            echo "   Article ID: " . $responseData['id'] . "\n";
            echo "   Title: " . $responseData['title'] . "\n";
            
            // Vérification immédiate dans la base
            echo "\n3. Vérification immédiate en base...\n";
            $verify = \Illuminate\Support\Facades\DB::table('articles')
                ->where('id', $responseData['id'])
                ->first();
            
            if ($verify) {
                echo "✅ Article trouvé en base:\n";
                echo "   ID: " . $verify->id . "\n";
                echo "   Title: " . $verify->title . "\n";
                echo "   Created: " . $verify->created_at . "\n";
                echo "   Published: " . ($verify->is_published ? 'YES' : 'NO') . "\n";
            } else {
                echo "❌ Article NON trouvé en base !\n";
            }
        }
    } else {
        echo "❌ Erreur API (HTTP {$httpCode2})\n";
        if (isset($responseData['message'])) {
            echo "   Message: " . $responseData['message'] . "\n";
        }
        if (isset($responseData['errors'])) {
            echo "   Erreurs:\n";
            foreach ($responseData['errors'] as $field => $errors) {
                echo "     {$field}: " . implode(', ', $errors) . "\n";
            }
        }
    }
}

// Test 4: Compter tous les articles
echo "\n4. Total articles dans la base:\n";
$totalArticles = \Illuminate\Support\Facades\DB::table('articles')->count();
echo "   Total: {$totalArticles}\n";

$lastArticles = \Illuminate\Support\Facades\DB::table('articles')
    ->orderBy('created_at', 'desc')
    ->limit(3)
    ->get();

echo "   3 derniers articles:\n";
foreach ($lastArticles as $article) {
    echo "     - ID: {$article->id} | {$article->title} | {$article->created_at}\n";
}

echo "\n=== TEST TERMINÉ ===\n";

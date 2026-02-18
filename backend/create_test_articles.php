<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Creating Test Articles ===\n";

// Create multiple test articles
$articles = [
    [
        'title' => 'Les bienfaits du yoga pour la santé mentale',
        'excerpt' => 'Découvrez comment le yoga peut améliorer votre bien-être mental et physique.',
        'content' => '<p>Le yoga est une pratique millénaire qui offre de nombreux bienfaits pour la santé mentale...</p>',
        'featured_image_url' => 'https://images.unsplash.com/photo-1545205597-3d9d02c29597?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'category_id' => 1,
        'author_id' => 1,
        'published_date' => date('Y-m-d H:i:s'),
        'is_published' => true,
        'read_time' => 5
    ],
    [
        'title' => 'Alimentation équilibrée : les bases',
        'excerpt' => 'Apprenez les principes fondamentaux d une alimentation saine et équilibrée.',
        'content' => '<p>Une alimentation équilibrée est essentielle pour maintenir une bonne santé...</p>',
        'featured_image_url' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'category_id' => 1,
        'author_id' => 1,
        'published_date' => date('Y-m-d H:i:s'),
        'is_published' => true,
        'read_time' => 7
    ],
    [
        'title' => '5 exercices pour renforcer le dos',
        'excerpt' => 'Renforcez votre dos avec ces exercices simples et efficaces.',
        'content' => '<p>Le mal de dos est un problème courant qui peut être soulagé par des exercices réguliers...</p>',
        'featured_image_url' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'category_id' => 1,
        'author_id' => 1,
        'published_date' => date('Y-m-d H:i:s'),
        'is_published' => true,
        'read_time' => 4
    ],
    [
        'title' => 'La méditation pour débutants',
        'excerpt' => 'Guide complet pour commencer la méditation et réduire le stress.',
        'content' => '<p>La méditation est une pratique qui peut transformer votre vie quotidienne...</p>',
        'featured_image_url' => 'https://images.unsplash.com/photo-1593873649473-2b8c3a8a9a5a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'category_id' => 1,
        'author_id' => 1,
        'published_date' => date('Y-m-d H:i:s'),
        'is_published' => true,
        'read_time' => 6
    ],
    [
        'title' => 'Importance de l hydratation',
        'excerpt' => 'Pourquoi boire suffisamment d eau est crucial pour votre santé.',
        'content' => '<p>L hydratation est essentielle au bon fonctionnement de notre organisme...</p>',
        'featured_image_url' => 'https://images.unsplash.com/photo-1548839148-1c0a5ed37053?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'category_id' => 1,
        'author_id' => 1,
        'published_date' => date('Y-m-d H:i:s'),
        'is_published' => true,
        'read_time' => 3
    ]
];

foreach ($articles as $articleData) {
    $article = \App\Models\Article::create($articleData);
    echo "Created article: " . $article->title . " (ID: " . $article->id . ")\n";
}

echo "\n=== Articles Created ===\n";
$totalArticles = \App\Models\Article::count();
echo "Total articles in database: " . $totalArticles . "\n";

echo "\n=== Test Complete ===\n";

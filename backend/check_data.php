<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== VÉRIFICATION DES DONNÉES ===\n\n";

// Articles
echo "📄 ARTICLES (" . \App\Models\Article::count() . "):\n";
$articles = \App\Models\Article::take(5)->get(['id', 'title', 'slug']);
foreach ($articles as $article) {
    echo "- ID: {$article->id} - {$article->title}\n";
}
echo "\n";

// Categories
echo "📂 CATÉGORIES (" . \App\Models\Category::count() . "):\n";
$categories = \App\Models\Category::take(5)->get(['id', 'name']);
foreach ($categories as $category) {
    echo "- ID: {$category->id} - {$category->name}\n";
}
echo "\n";

// FAQs
echo "❓ FAQS (" . \App\Models\FAQ::count() . "):\n";
$faqs = \App\Models\FAQ::take(3)->get(['id', 'question']);
foreach ($faqs as $faq) {
    echo "- ID: {$faq->id} - {$faq->question}\n";
}
echo "\n";

// Users
echo "👥 UTILISATEURS (" . \App\Models\User::count() . "):\n";
$users = \App\Models\User::get(['id', 'name', 'email', 'role']);
foreach ($users as $user) {
    echo "- ID: {$user->id} - {$user->name} ({$user->email}) - {$user->role}\n";
}
echo "\n";

// Newsletters
echo "📧 NEWSLETTERS (" . \App\Models\Newsletter::count() . "):\n";
$newsletters = \App\Models\Newsletter::take(3)->get(['id', 'email', 'subscribed_at']);
foreach ($newsletters as $newsletter) {
    echo "- ID: {$newsletter->id} - {$newsletter->email} ({$newsletter->subscribed_at})\n";
}

echo "\n=== RÉSUMÉ ===\n";
echo "✅ Articles: " . \App\Models\Article::count() . "\n";
echo "✅ Categories: " . \App\Models\Category::count() . "\n";
echo "✅ FAQs: " . \App\Models\FAQ::count() . "\n";
echo "✅ Users: " . \App\Models\User::count() . "\n";
echo "✅ Newsletters: " . \App\Models\Newsletter::count() . "\n";

echo "\n=== VÉRIFICATION TERMINÉE ===\n";

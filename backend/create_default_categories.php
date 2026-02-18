<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Creating Default Categories ===\n";

// Default categories data
$defaultCategories = [
    [
        'name' => 'Nutrition et Alimentation',
        'slug' => 'nutrition-alimentation',
        'description' => 'Conseils sur une alimentation saine et équilibrée pour une meilleure santé',
        'color' => '#10B981',
        'icon' => 'utensils',
        'is_active' => true
    ],
    [
        'name' => 'Prévention et Bien-être',
        'slug' => 'prevention-bien-etre',
        'description' => 'Stratégies de prévention et conseils pour améliorer votre bien-être quotidien',
        'color' => '#3B82F6',
        'icon' => 'heart',
        'is_active' => true
    ],
    [
        'name' => 'Santé mentale',
        'slug' => 'sante-mentale',
        'description' => 'Gestion du stress, méditation et santé psychologique',
        'color' => '#8B5CF6',
        'icon' => 'brain',
        'is_active' => true
    ],
    [
        'name' => 'Exercice et Fitness',
        'slug' => 'exercice-fitness',
        'description' => 'Programmes d\'exercice, fitness et activités physiques',
        'color' => '#EF4444',
        'icon' => 'dumbbell',
        'is_active' => true
    ],
    [
        'name' => 'Interview et témoignage',
        'slug' => 'interview-temoignage',
        'description' => 'Témoignages et interviews d\'experts de la santé',
        'color' => '#F59E0B',
        'icon' => 'microphone',
        'is_active' => true
    ],
    [
        'name' => 'Puériculture',
        'slug' => 'puericulture',
        'description' => 'Conseils pour la santé et le bien-être des enfants',
        'color' => '#EC4899',
        'icon' => 'baby',
        'is_active' => true
    ],
    [
        'name' => 'Maladies chroniques',
        'slug' => 'maladies-chroniques',
        'description' => 'Information et gestion des maladies chroniques',
        'color' => '#6B7280',
        'icon' => 'stethoscope',
        'is_active' => true
    ],
    [
        'name' => 'Médecine naturelle',
        'slug' => 'medecine-naturelle',
        'description' => 'Remèdes naturels et médecines alternatives',
        'color' => '#059669',
        'icon' => 'leaf',
        'is_active' => true
    ]
];

// Clear existing categories
echo "Clearing existing categories...\n";
\App\Models\Category::truncate();

// Create default categories
echo "Creating default categories...\n";
foreach ($defaultCategories as $categoryData) {
    $category = \App\Models\Category::create($categoryData);
    echo "✓ Created: " . $category->name . " (ID: " . $category->id . ")\n";
}

echo "\n=== Categories Created ===\n";
$totalCategories = \App\Models\Category::count();
echo "Total categories created: " . $totalCategories . "\n";

echo "\n=== Category List ===\n";
$categories = \App\Models\Category::orderBy('name')->get();
foreach ($categories as $category) {
    echo "- " . $category->name . " (" . $category->slug . ")\n";
    echo "  Description: " . $category->description . "\n";
    echo "  Color: " . $category->color . "\n";
    echo "  Icon: " . $category->icon . "\n";
    echo "  Active: " . ($category->is_active ? 'Yes' : 'No') . "\n";
    echo "\n";
}

echo "=== Complete ===\n";

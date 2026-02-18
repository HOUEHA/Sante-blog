<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Creating Default FAQs ===\n";

// Get categories for FAQ assignment
$categories = [
    'Nutrition et Alimentation' => 1,
    'Prévention et Bien-être' => 2,
    'Santé mentale' => 3,
    'Exercice et Fitness' => 4,
    'Interview et témoignage' => 5,
    'Puériculture' => 6,
    'Maladies chroniques' => 7,
    'Médecine naturelle' => 8
];

// Default FAQs data
$defaultFAQs = [
    // Nutrition et Alimentation
    [
        'category' => 'Nutrition et Alimentation',
        'question' => 'Quels sont les aliments les plus nutritifs pour la santé ?',
        'answer' => 'Les aliments les plus nutritifs incluent les légumes verts (épinards, kale), les fruits rouges (myrtilles, framboises), les poissons gras (saumon, sardines), les noix et graines, les légumineuses (lentilles, pois chiches), et les céréales complètes. Ces aliments sont riches en vitamines, minéraux, antioxydants et fibres essentiels.',
        'is_active' => true
    ],
    [
        'category' => 'Nutrition et Alimentation',
        'question' => 'Combien de litres d\'eau devrais-je boire par jour ?',
        'answer' => 'Il est recommandé de boire environ 1.5 à 2 litres d\'eau par jour, soit 8 verres. Cependant, les besoins peuvent varier selon l\'âge, le niveau d\'activité physique, le climat et l\'état de santé. Écoutez votre corps et buvez lorsque vous avez soif.',
        'is_active' => true
    ],
    [
        'category' => 'Nutrition et Alimentation',
        'question' => 'Les régimes végétariens sont-ils sains ?',
        'answer' => 'Oui, les régimes végétariens peuvent être très sains s\'ils sont bien planifiés. Ils doivent inclure des protéines complètes (légumineuses, céréales), du fer (légumes verts, lentilles), du calcium (produits laitiers, tofu), et de la vitamine B12 (suppléments ou aliments enrichis).',
        'is_active' => true
    ],
    
    // Prévention et Bien-être
    [
        'category' => 'Prévention et Bien-être',
        'question' => 'Combien d\'heures de sommeil sont nécessaires ?',
        'answer' => 'Les adultes ont besoin de 7-9 heures de sommeil par nuit. Les enfants et adolescents ont besoin de plus (9-11 heures). Un sommeil de qualité est essentiel pour la récupération physique, la santé mentale, et le bon fonctionnement du système immunitaire.',
        'is_active' => true
    ],
    [
        'category' => 'Prévention et Bien-être',
        'question' => 'Quels sont les signes du stress chronique ?',
        'answer' => 'Les signes du stress chronique incluent la fatigue persistante, les maux de tête fréquents, les troubles du sommeil, l\'irritabilité, les problèmes de concentration, les tensions musculaires, et les changements d\'appétit. Il est important de consulter un professionnel si ces symptômes persistent.',
        'is_active' => true
    ],
    
    // Santé mentale
    [
        'category' => 'Santé mentale',
        'question' => 'Comment pratiquer la méditation pour débutants ?',
        'answer' => 'Pour débuter la méditation, asseyez-vous confortablement, fermez les yeux, et concentrez-vous sur votre respiration. Commencez par 5-10 minutes par jour. Utilisez des applications guidées ou des vidéos en ligne. La régularité est plus importante que la durée.',
        'is_active' => true
    ],
    [
        'category' => 'Santé mentale',
        'question' => 'Quand faut-il consulter un psychologue ?',
        'answer' => 'Il est recommandé de consulter un psychologue lorsque vous ressentez une détresse émotionnelle persistante, des difficultés relationnelles, des troubles du sommeil ou de l\'appétit, ou lorsque vous traversez une période difficile. N\'hésitez pas à demander de l\'aide.',
        'is_active' => true
    ],
    
    // Exercice et Fitness
    [
        'category' => 'Exercice et Fitness',
        'question' => 'Quel type d\'exercice pour perdre du poids ?',
        'answer' => 'Pour perdre du poids efficacement, combinez des exercices cardio (course, vélo, natation) 3-4 fois par semaine avec des exercices de renforcement musculaire 2-3 fois par semaine. L\'important est la régularité et de trouver des activités que vous aimez.',
        'is_active' => true
    ],
    [
        'category' => 'Exercice et Fitness',
        'question' => 'Combien de temps d\'exercice par semaine ?',
        'answer' => 'L\'OMS recommande au moins 150 minutes d\'exercice modéré par semaine (30 minutes, 5 jours) ou 75 minutes d\'exercice intense. Ajoutez 2 jours de renforcement musculaire. L\'important est d\'être régulier.',
        'is_active' => true
    ],
    
    // Puériculture
    [
        'category' => 'Puériculture',
        'question' => 'À quel âge commencer la diversification alimentaire ?',
        'answer' => 'La diversification alimentaire commence généralement entre 4 et 6 mois, quand bébé tient bien sa tête et s\'intéresse à la nourriture. Commencez par des légumes cuits et mixés, un par un, en attendant 3 jours entre chaque nouvel aliment.',
        'is_active' => true
    ],
    [
        'category' => 'Puériculture',
        'question' => 'Combien de temps un bébé doit-il dormir ?',
        'answer' => 'Les besoins en sommeil varient avec l\'âge: nouveau-nés (0-3 mois): 14-17 heures, bébés (4-11 mois): 12-16 heures, toddlers (1-2 ans): 11-14 heures. Chaque bébé est différent, respectez son rythme.',
        'is_active' => true
    ],
    
    // Maladies chroniques
    [
        'category' => 'Maladies chroniques',
        'question' => 'Comment gérer le diabète au quotidien ?',
        'answer' => 'La gestion du diabète inclut la surveillance régulière de la glycémie, une alimentation équilibrée, l\'activité physique régulière, la prise médicamenteuse conforme, et le suivi médical régulier. L\'éducation du patient et le soutien familial sont essentiels.',
        'is_active' => true
    ],
    
    // Médecine naturelle
    [
        'category' => 'Médecine naturelle',
        'question' => 'Quelles plantes pour soulager le stress ?',
        'answer' => 'Plusieurs plantes peuvent aider: la camomille (calmante), la lavande (relaxante), le millepertuis (dépression légère), la valériane (sommeil), et le thé vert (antioxydant). Consultez toujours un professionnel avant usage, surtout si vous prenez des médicaments.',
        'is_active' => true
    ]
];

// Clear existing FAQs
echo "Clearing existing FAQs...\n";
\App\Models\FAQ::truncate();

// Create default FAQs
echo "Creating default FAQs...\n";
foreach ($defaultFAQs as $faqData) {
    $faq = \App\Models\FAQ::create($faqData);
    echo "✓ Created: " . $faq->question . " (Category: " . $faq->category . ")\n";
}

echo "\n=== FAQs Created ===\n";
$totalFAQs = \App\Models\FAQ::count();
echo "Total FAQs created: " . $totalFAQs . "\n";

echo "\n=== FAQ Summary by Category ===\n";
foreach ($categories as $categoryName => $categoryId) {
    $count = \App\Models\FAQ::where('category', $categoryName)->count();
    echo "- " . $categoryName . ": " . $count . " questions\n";
}

echo "\n=== Complete ===\n";

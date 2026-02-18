<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== ALIMENTATION CORRECTE DU CONTENU ===\n\n";

// Récupérer les vrais slugs de catégories
$nutritionCategory = \App\Models\Category::where('slug', 'nutrition-alimentation')->first();
$preventionCategory = \App\Models\Category::where('slug', 'prevention-bien-etre')->first();
$interviewCategory = \App\Models\Category::where('slug', 'interview-temoignage')->first();

echo "📁 Catégories trouvées:\n";
echo "   Nutrition: " . ($nutritionCategory ? "✅ ID {$nutritionCategory->id}" : "❌ Non trouvée") . "\n";
echo "   Prévention: " . ($preventionCategory ? "✅ ID {$preventionCategory->id}" : "❌ Non trouvée") . "\n";
echo "   Interview: " . ($interviewCategory ? "✅ ID {$interviewCategory->id}" : "❌ Non trouvée") . "\n\n";

if (!$nutritionCategory || !$preventionCategory || !$interviewCategory) {
    echo "❌ Catégories manquantes, arrêt du script.\n";
    exit(1);
}

// Articles pour la catégorie Nutrition et Alimentation
$nutritionArticles = [
    [
        'title' => 'Les Fondamentaux d\'une Alimentation Saine',
        'slug' => 'fondamentaux-alimentation-saine',
        'category_id' => $nutritionCategory->id,
        'excerpt' => 'Découvrez les principes essentiels d\'une nutrition équilibrée pour une vie saine et énergique.',
        'content' => '<h2>Les Bases de la Nutrition Équilibrée</h2>
<p>Une alimentation saine est la fondation d\'une vie énergique et équilibrée. Elle repose sur des principes simples mais essentiels qui garantissent à notre corps tous les nutriments dont il a besoin.</p>

<h3>Les Groupes Alimentaires Essentiels</h3>
<p>Une alimentation équilibrée doit inclure :</p>
<ul>
<li><strong>Protéines</strong> : Viandes maigres, poissons, œufs, légumineuses</li>
<li><strong>Glucides complexes</strong> : Céréales complètes, légumes, fruits</li>
<li><strong>Lipides de qualité</strong> : Huiles végétales, avocats, noix</li>
<li><strong>Vitamines et minéraux</strong> : Fruits et légumes variés</li>
<li><strong>Fibres</strong> : Légumes, fruits, céréales complètes</li>
</ul>

<h3>Les Portions Recommandées</h3>
<p>La pyramide alimentaire nous guide sur les quantités idéales :</p>
<ul>
<li>6-8 portions de céréales</li>
<li>4-5 portions de fruits et légumes</li>
<li>2-3 portions de protéines</li>
<li>2-3 portions de produits laitiers</li>
<li>Limiter les sucres et gras</li>
</ul>

<h3>L\'Importance de l\'Hydratation</h3>
<p>L\'eau est essentielle au bon fonctionnement de notre organisme. Buvez au moins 1.5L d\'eau par jour, plus en cas d\'activité physique.</p>

<h2>Conclusion</h2>
<p>Adopter ces principes fondamentaux vous mettra sur la voie d\'une alimentation saine et durable. N\'oubliez pas que la modération et la variété sont les clés du succès.</p>',
        'featured_image_url' => '/images/alimentation-saine.jpg',
        'read_time' => 8,
        'is_published' => true,
        'published_date' => now(),
        'author_id' => 1, // Admin user
    ],
    [
        'title' => 'Les Super-Aliments à Intégrer dans Votre Quotidien',
        'slug' => 'super-aliments-quotidien',
        'category_id' => $nutritionCategory->id,
        'excerpt' => 'Découvrez les aliments exceptionnels qui peuvent transformer votre santé et votre bien-être quotidien.',
        'content' => '<h2>Qu\'est-ce qu\'un Super-Aliment?</h2>
<p>Les super-aliments sont des aliments particulièrement riches en nutriments bénéfiques pour la santé. Ils offrent une concentration exceptionnelle de vitamines, minéraux et antioxydants.</p>

<h3>Les Incontournables</h3>
<h4>Les Baies (Myrtilles, Framboises)</h4>
<p>Riches en antioxydants, elles protègent nos cellules du vieillissement prématuré et améliorent la mémoire.</p>

<h4>Les Graines de Chia</h4>
<p>Excellente source d\'oméga-3, de fibres et de protéines. Idéales pour la digestion et la satiété.</p>

<h4>Le Curcuma</h4>
<p>Puissant anti-inflammatoire naturel, il soutient le système immunitaire et protège les articulations.</p>

<h4>Les Épinards</h4>
<p>Concentré en fer, calcium et vitamines K et A. Essentiels pour les os et le sang.</p>

<h4>Le Saumon</h4>
<p>Riche en oméga-3 DHA et EPA, excellent pour le cerveau et le cœur.</p>

<h3>Comment les Intégrer?</h3>
<ul>
<li><strong>Petit-déjeuner</strong> : Ajoutez des graines de chia à votre yaourt</li>
<li><strong>Déjeuner</strong> : Salade avec épinards et saumon</li>
<li><strong>Dîner</strong> : Curcuma dans vos plats chauds</li>
<li><strong>Collation</strong> : Poignée de baies fraîches</li>
</ul>

<h2>Conclusion</h2>
<p>Intégrer ces super-aliments progressivement dans votre alimentation vous apportera des bienfaits visibles sur votre énergie et votre santé globale.</p>',
        'featured_image_url' => '/images/super-aliments.jpg',
        'read_time' => 6,
        'is_published' => true,
        'published_date' => now(),
        'author_id' => 1,
    ],
    [
        'title' => 'Comprendre les Étiquettes Nutritionnelles',
        'slug' => 'comprendre-etiquettes-nutritionnelles',
        'category_id' => $nutritionCategory->id,
        'excerpt' => 'Apprenez à décoder les étiquettes alimentaires pour faire des choix éclairés au supermarché.',
        'content' => '<h2>Décoder les Étiquettes Alimentaires</h2>
<p>Savoir lire les étiquettes nutritionnelles est essentiel pour faire des choix alimentaires éclairés. Voici comment interpréter les informations clés.</p>

<h3>Les Informations Obligatoires</h3>
<h4>Valeur Énergétique</h4>
<p>Exprimée en kilocalories (kcal) et kilojoules (kJ). Pour un adulte moyen, les besoins sont de 2000-2500 kcal par jour.</p>

<h4>Macronutriments</h4>
<ul>
<li><strong>Protéines</strong> : Essentielles pour les muscles (env. 50g/jour)</li>
<li><strong>Glucides</strong> : Source d\'énergie principale (env. 250-300g/jour)</li>
<li><strong>Lipides</strong> : Concentré d\'énergie (env. 70-80g/jour)</li>
</ul>

<h3>Les Additifs à Surveiller</h3>
<h4>Sucres Ajoutés</h4>
<p>L\'OMS recommande de limiter à 25g par jour. Attention aux sucres cachés : sirop de glucose, fructose, dextrose.</p>

<h4>Sel (Sodium)</h4>
<p>Ne pas dépasser 6g par jour. Le sel excessif augmente le risque d\'hypertension.</p>

<h4>Acides Gras Saturés</h4>
<p>Limiter à 20g par jour. Privilégier les insaturés (huiles végétales, poissons).</p>

<h3>Les Allergènes Majeurs</h3>
<p>14 allergènes doivent être clairement mentionnés :</p>
<ul>
<li>Arachides, soja, produits laitiers</li>
<li>Œufs, poisson, crustacés</li>
<li>Fruits à coque, sésame, moutarde</li>
<li>Céréales contenant du gluten, lupin</li>
</ul>

<h3>Astuces Pratiques</h3>
<ul>
<li><strong>Lire la liste d\'ingrédients</strong> : Les premiers sont les plus abondants</li>
<li><strong>Comparer les produits</strong> : Même marque, formats différents</li>
<li><strong>Méfier des "allégations santé"</strong> : Vérifier la composition</li>
<li><strong>Pourcentage par portion</strong> : Attention aux portions irréalistes</li>
</ul>

<h2>Conclusion</h2>
<p>Devenir un consommateur averti demande un peu d\'entraînement. Avec ces connaissances, vous ferez des choix plus sains pour vous et votre famille.</p>',
        'featured_image_url' => '/images/etiquettes-nutritionnelles.jpg',
        'read_time' => 7,
        'is_published' => true,
        'published_date' => now(),
        'author_id' => 1,
    ]
];

// Articles pour la catégorie Prévention et Bien-être
$preventionArticles = [
    [
        'title' => 'Les Vaccins Essentiels à Tout Âge',
        'slug' => 'vaccins-essentiels-tout-age',
        'category_id' => $preventionCategory->id,
        'excerpt' => 'Guide complet sur les vaccins recommandés à chaque étape de la vie pour une protection optimale.',
        'content' => '<h2>L\'Importance de la Vaccination</h2>
<p>La vaccination est l\'un des outils de prévention les plus efficaces contre les maladies infectieuses. Elle protège à la fois l\'individu et la communauté.</p>

<h3>Calendrier Vaccinal Adulte</h3>
<h4>De 18 à 25 ans</h4>
<ul>
<li>Rappel DTP (diphtérie, tétanos, poliomyélite)</li>
<li>Vaccin contre les infections à papillomavirus (HPV)</li>
<li>Vaccin contre la rougeole, les oreillons, la rubéole si non vacciné</li>
</ul>

<h4>De 25 à 65 ans</h4>
<ul>
<li>Rappel DTP tous les 10 ans</li>
<li>Vaccin contre la grippe saisonnière annuel</li>
<li>Vaccin contre la coqueluche si contact avec nourrissons</li>
</ul>

<h4>Après 65 ans</h4>
<ul>
<li>Rappel DTP tous les 10 ans</li>
<li>Vaccin contre la grippe annuel</li>
<li>Vaccin contre le pneumocoque</li>
<li>Vaccin contre le zona</li>
</ul>

<h3>Mythes et Réalités</h3>
<h4>Mythe: "Les vaccins causent l\'autisme"</h4>
<p>Réalité: Des études scientifiques majeures ont démontré l\'absence de lien entre vaccins et autisme.</p>

<h4>Mythe: "Les maladies ont disparu, on n\'a plus besoin de vaccins"</h4>
<p>Réalité: La baisse de la vaccination entraîne une réapparition rapide des maladies.</p>

<h2>Conclusion</h2>
<p>La vaccination est un acte de responsabilité individuelle et collective. Consultez votre médecin pour un calendrier personnalisé.</p>',
        'featured_image_url' => '/images/vaccination-prevention.jpg',
        'read_time' => 10,
        'is_published' => true,
        'published_date' => now(),
        'author_id' => 1,
    ],
    [
        'title' => 'L\'Importance du Sommeil pour la Santé',
        'slug' => 'importance-sommeil-sante',
        'category_id' => $preventionCategory->id,
        'excerpt' => 'Découvrez pourquoi un sommeil de qualité est fondamental pour votre santé physique et mentale.',
        'content' => '<h2>Le Sommeil: Pilier de la Santé</h2>
<p>Le sommeil est aussi essentiel que l\'alimentation et l\'exercice physique. Il permet à notre corps de se régénérer et à notre cerveau de consolider les apprentissages.</p>

<h3>Les Cycles de Sommeil</h3>
<p>Une nuit de sommeil se compose de cycles de 90 minutes environ :</p>
<ul>
<li><strong>Sommeil léger</strong> : 50% du temps, transition vers le sommeil profond</li>
<li><strong>Sommeil profond</strong> : 20-25%, régénération physique</li>
<li><strong>Sommeil paradoxal</strong> : 20-25%, consolidation mémoire</li>
</ul>

<h3>Durées Recommandées</h3>
<ul>
<li><strong>Adultes (26-64 ans)</strong> : 7-9 heures par nuit</li>
<li><strong>Adolescents (14-17 ans)</strong> : 8-10 heures</li>
<li><strong>Enfants (6-13 ans)</strong> : 9-11 heures</li>
</ul>

<h3>Conséquences du Manque de Sommeil</h3>
<h4>Court terme</h4>
<ul>
<li>Baisse de concentration et de productivité</li>
<li>Irritabilité et sautes d\'humeur</li>
<li>Risque accru d\'accidents</li>
</ul>

<h4>Long terme</h4>
<ul>
<li>Prise de poids et risque de diabète</li>
<li>Maladies cardiovasculaires</li>
<li>Troubles de l\'humeur et dépression</li>
</ul>

<h3>Conseils pour un Meilleur Sommeil</h3>
<ul>
<li><strong>Horaires réguliers</strong> : Couchez-vous et levez-vous à heures fixes</li>
<li><strong>Éviter les écrans</strong> : Lumière bleue 1h avant de dormir</li>
<li><strong>Température fraîche</strong> : 18-19°C dans la chambre</li>
<li><strong>Limitation caféine</strong> : Après 14h</li>
<li><strong>Activité physique</strong> : Mais pas 2h avant de dormir</li>
</ul>

<h2>Conclusion</h2>
<p>Prioriser le sommeil est un investissement dans votre santé à long terme. Un sommeil de qualité améliore votre énergie, votre humeur et votre immunité.</p>',
        'featured_image_url' => '/images/sommeil-sante.jpg',
        'read_time' => 8,
        'is_published' => true,
        'published_date' => now(),
        'author_id' => 1,
    ]
];

// Articles pour la catégorie Interview et Témoignage
$interviewArticles = [
    [
        'title' => 'Interview: Dr. Martin, Cardiologue sur la Prévention Cardiovasculaire',
        'slug' => 'interview-dr-martin-cardiologue',
        'category_id' => $interviewCategory->id,
        'excerpt' => 'Le Dr. Martin partage son expertise sur la prévention des maladies cardiovasculaires et donne des conseils pratiques.',
        'content' => '<h2>Rencontre avec le Dr. Martin</h2>
<p>Le Dr. Martin, cardiologue depuis 15 ans, exerce au CHU de Lyon et spécialisé en prévention cardiovasculaire. Il nous partage son expertise.</p>

<h3>Votre Parcours Professionnel</h3>
<p><strong>Blog Santé:</strong> Qu\'est-ce qui vous a mené à la cardiologie ?</p>
<p><strong>Dr. Martin:</strong> J\'ai toujours été fasciné par le cœur, cet organe vital qui bat inlassablement. La cardiologie me permet d\'avoir un impact direct sur la vie de mes patients.</p>

<h3>Les Facteurs de Risque à Surveiller</h3>
<p><strong>Blog Santé:</strong> Quels sont les principaux facteurs de risque que vous observez ?</p>
<p><strong>Dr. Martin:</strong> Les facteurs modifiables sont les plus importants : hypertension, cholestérol, tabagisme, sédentarité et alimentation. Heureusement, on peut agir sur chacun !</p>

<h3>Conseils Pratiques du Quotidien</h3>
<h4>L\'Alimentation Cœur-Santé</h4>
<ul>
<li>Privilégier les oméga-3 (poisson, noix)</li>
<li>Limiter les graisses saturées</li>
<li>Consommer 5 fruits et légumes par jour</li>
<li>Réduire le sel à moins de 6g par jour</li>
</ul>

<h4>L\'Activité Physique Essentielle</h4>
<ul>
<li>30 minutes de marche rapide par jour</li>
<li>2-3 séances de sport par semaine</li>
<li>Éviter le sédentarisme prolongé</li>
</ul>

<h3>Les Erreurs à Éviter</h3>
<p><strong>Blog Santé:</strong> Quelles sont les erreurs les plus fréquentes ?</p>
<p><strong>Dr. Martin:</strong> Négliger les symptômes, penser que "ça n\'arrive qu\'aux autres", et reporter les consultations de prévention. Le dépistage précoce sauve des vies.</p>

<h3>Message Final</h3>
<p><strong>Blog Santé:</strong> Quel message final souhaitez-vous partager ?</p>
<p><strong>Dr. Martin:</strong> Votre cœur est votre moteur. Prenez-en soin chaque jour. La prévention n\'est pas une contrainte, c\'est un investissement pour votre avenir.</p>

<h2>Conclusion</h2>
<p>Cette interview avec le Dr. Martin nous rappelle l\'importance de la prévention cardiovasculaire. Des gestes simples au quotidien peuvent faire toute la différence.</p>',
        'featured_image_url' => '/images/interview-dr-martin.jpg',
        'read_time' => 12,
        'is_published' => true,
        'published_date' => now(),
        'author_id' => 1,
    ],
    [
        'title' => 'Témoignage: Sophie, 35 ans, Son Parcours vers une Alimentation Saine',
        'slug' => 'temoignage-sophie-alimentation-saine',
        'category_id' => $interviewCategory->id,
        'excerpt' => 'Sophie partage son parcours inspirant de transformation à travers une meilleure alimentation et ses bienfaits au quotidien.',
        'content' => '<h2>Rencontre avec Sophie</h2>
<p>Sophie, 35 ans, mère de deux enfants, a complètement transformé son alimentation il y a deux ans. Elle nous partage son parcours et ses conseils.</p>

<h3>Le Point de Départ</h3>
<p><strong>Blog Santé:</strong> Qu\'est-ce qui vous a poussé à changer votre alimentation ?</p>
<p><strong>Sophie:</strong> J\'étais toujours fatiguée, j\'avais pris du poids après ma deuxième grossesse, et je ne me reconnaissais plus. Mon médecin m\'a alertée sur mon cholestérol.</p>

<h3>Les Premiers Changements</h3>
<p><strong>Blog Santé:</strong> Par où avez-vous commencé ?</p>
<p><strong>Sophie:</strong> Par des changements simples ! J\'ai arrêté les sodas et les plats préparés. J\'ai commencé à cuisiner maison avec des produits frais. Les deux premières semaines ont été difficiles.</p>

<h3>Les Bienfaits Ressentis</h3>
<h4>Après 1 mois</h4>
<ul>
<li>Plus d\'énergie le matin</li>
<li>Peau plus éclatante</li>
<li>Moins de ballonnements</li>
</ul>

<h4>Après 3 mois</h4>
<ul>
<li>Perte de 4 kg sans effort</li>
<li>Sommeil de meilleure qualité</li>
<li>Humeur plus stable</li>
</ul>

<h4>Après 6 mois</h4>
<ul>
<li>Perte de 8 kg au total</li>
<li>Cholestérol normalisé</li>
<li>Plus confiance en moi</li>
</ul>

<h3>Les Défis Rencontrés</h3>
<p><strong>Blog Santé:</strong> Quelles ont été les difficultés ?</p>
<p><strong>Sophie:</strong> Le regard des autres au début, les tentations lors des fêtes, et le manque de temps pour cuisiner. J\'ai appris à préparer mes repas à l\'avance.</p>

<h3>Les Astuces Pratiques</h3>
<h4>Pour les Enfants</h4>
<ul>
<li>Faire participer les enfants à la cuisine</li>
<li>Cacher les légumes dans les plats</li>
<li>Présenter les aliments de manière ludique</li>
</ul>

<h4>Pour le Manque de Temps</h4>
<ul>
<li>Batch cooking le dimanche</li>
<li>Plats simples en 20 minutes</li>
<li>Légumes surgelés de qualité</li>
</ul>

<h3>L\'Impact sur la Famille</h3>
<p><strong>Blog Santé:</strong> Votre famille a-t-elle suivi ?</p>
<p><strong>Sophie:</strong> Mon mari a perdu 5 kg sans s\'en rendre compte ! Les enfants ont plus d\'énergie et tombent moins malades. C\'est devenu un projet familial.</p>

<h3>Message pour les Lecteurs</h3>
<p><strong>Blog Santé:</strong> Que diriez-vous à ceux qui hésitent ?</p>
<p><strong>Sophie:</strong> Ne soyez pas trop exigeants au début. Un petit changement vaut mieux que pas de changement. Chaque pas est une victoire. Et surtout, soyez patient avec vous-même.</p>

<h2>Conclusion</h2>
<p>Le témoignage de Sophie nous montre que transformer son alimentation est possible avec de la persévérance et des changements progressifs. Les bienfaits dépassent largement les efforts fournis.</p>',
        'featured_image_url' => '/images/temoignage-sophie.jpg',
        'read_time' => 10,
        'is_published' => true,
        'published_date' => now(),
        'author_id' => 1,
    ]
];

// Fusionner tous les articles
$allArticles = array_merge($nutritionArticles, $preventionArticles, $interviewArticles);

// Insérer les articles
echo "📝 Insertion des articles...\n";
foreach ($allArticles as $article) {
    try {
        $created = \App\Models\Article::updateOrCreate(
            ['slug' => $article['slug']],
            $article
        );
        
        if ($created->wasRecentlyCreated) {
            echo "✅ Article créé: {$article['title']}\n";
        } else {
            echo "🔄 Article mis à jour: {$article['title']}\n";
        }
    } catch (\Exception $e) {
        echo "❌ Erreur pour '{$article['title']}': " . $e->getMessage() . "\n";
    }
}

echo "\n📊 Résumé de l\'opération:\n";
echo "   Articles traités: " . count($allArticles) . "\n";

$totalArticles = \App\Models\Article::count();
echo "   Total articles dans la base: {$totalArticles}\n";

echo "\n🎯 Contenu par catégorie:\n";
echo "   Nutrition et Alimentation: " . \App\Models\Article::where('category_id', $nutritionCategory->id)->count() . " articles\n";
echo "   Prévention et Bien-être: " . \App\Models\Article::where('category_id', $preventionCategory->id)->count() . " articles\n";
echo "   Interview et témoignage: " . \App\Models\Article::where('category_id', $interviewCategory->id)->count() . " articles\n";

echo "\n=== ALIMENTATION TERMINÉE ===\n";

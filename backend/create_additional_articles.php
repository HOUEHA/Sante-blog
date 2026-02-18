<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Creating Additional Articles ===\n";

// Get categories
$categories = [
    'interview' => \App\Models\Category::where('slug', 'interview-temoignage')->first(),
    'maladies' => \App\Models\Category::where('slug', 'maladies-chroniques')->first(),
    'medecine-naturelle' => \App\Models\Category::where('slug', 'medecine-naturelle')->first(),
];

$additionalArticles = [
    [
        'title' => 'Témoignage : Comment j\'ai vaincu la dépression',
        'slug' => 'temoignage-vaincu-depression',
        'excerpt' => 'Le parcours inspirant de Marie, 32 ans, qui a surmonté la dépression grâce à une approche holistique.',
        'content' => '
            <h2>Le parcours de Marie : de l\'obscurité à la lumière</h2>
            <p>Marie, 32 ans, partage son histoire poignante de lutte contre la dépression et comment elle a retrouvé le goût de vivre.</p>
            
            <h3>Le début de la lutte</h3>
            <p>"Tout a commencé il y a trois ans," raconte Marie. "Je me sentais vide, sans énergie, et même les choses que j\'aimais ne m\'intéressaient plus."</p>
            
            <h3>Les étapes de la guérison</h3>
            <p>Son parcours inclut :</p>
            <ul>
                <li>Une thérapie cognitivo-comportementale</li>
                <li>La pratique régulière de la méditation</li>
                <li>Une activité physique progressive</li>
                <li>Le soutien de ses proches</li>
                <li>Un ajustement de son alimentation</li>
            </ul>
            
            <h3>Les leçons apprises</h3>
            <p>"La plus grande leçon," conclut Marie, "c\'est que demander de l\'aide n\'est pas un signe de faiblesse, mais de courage. Chaque petit pas compte."</p>
            
            <h3>Message d\'espoir</h3>
            <p>Aujourd\'hui, Marie vit pleinement et aide les autres à travers un groupe de soutien. "Si mon histoire peut aider une seule personne, alors tout ce parcours en valait la peine."</p>
        ',
        'featured_image_url' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'category_id' => $categories['interview']->id,
        'author_id' => 1,
        'published_date' => \Carbon\Carbon::now()->subDays(9),
        'is_published' => true,
        'read_time' => 12,
    ],
    [
        'title' => 'Vivre avec le diabète : guide pratique au quotidien',
        'slug' => 'vivre-diabete-guide-quotidien',
        'excerpt' => 'Conseils pratiques et stratégies pour gérer le diabète au quotidien et maintenir une bonne qualité de vie.',
        'content' => '
            <h2>Le diabète : une condition gérable</h2>
            <p>Vivre avec le diabète demande des ajustements, mais n\'empêche pas de mener une vie pleine et active.</p>
            
            <h3>La surveillance glycémique</h3>
            <p>Le suivi régulier de votre glycémie est fondamental :</p>
            <ul>
                <li>Mesurez avant et après les repas</li>
                <li>Tenez un journal de vos lectures</li>
                <li>Identifiez les aliments qui influencent votre glycémie</li>
                <li>Adaptez vos traitements en conséquence</li>
            </ul>
            
            <h3>L\'alimentation équilibrée</h3>
            <p>Une alimentation adaptée est cruciale :</p>
            <ul>
                <li>Privilégiez les aliments à index glycémique bas</li>
                <li>Faites 3 repas réguliers et 2 collations</li>
                <li>Limitez les sucres rapides et les aliments transformés</li>
                <li>Privilégiez les fibres et les protéines maigres</li>
            </ul>
            
            <h3>L\'activité physique adaptée</h3>
            <p>L\'exercice est votre allié :</p>
            <ul>
                <li>30 minutes de marche modérée quotidienne</li>
                <li>Surveillez votre glycémie avant et après l\'effort</li>
                <li>Ayez toujours une collation sucrée avec vous</li>
                <li>Choisissez des activités que vous aimez</li>
            </ul>
            
            <h3>La gestion du stress</h3>
            <p>Le stress peut affecter votre glycémie :</p>
            <ul>
                <li>Pratiquez la relaxation ou la méditation</li>
                <li>Assurez-vous d\'un sommeil suffisant</li>
                <li>Ne négligez pas votre santé mentale</li>
                <li>Rejoignez des groupes de soutien</li>
            </ul>
            
            <h3>Le suivi médical régulier</h3>
            <p>N\'oubliez pas :</p>
            <ul>
                <li>Consultez votre médecin tous les 3-6 mois</li>
                <li>Faites les examens recommandés (yeux, pieds, reins)</li>
                <li>Revoyez votre traitement avec votre équipe soignante</li>
                <li>Informez-vous sur les nouvelles thérapies</li>
            </ul>
        ',
        'featured_image_url' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'category_id' => $categories['maladies']->id,
        'author_id' => 1,
        'published_date' => \Carbon\Carbon::now()->subDays(10),
        'is_published' => true,
        'read_time' => 15,
    ],
    [
        'title' => 'Les plantes médicinales : guide des essentiels',
        'slug' => 'plantes-medicinales-guide-essentiels',
        'excerpt' => 'Découvrez les plantes médicinales les plus utiles pour traiter les maux du quotidien.',
        'content' => '
            <h2>La pharmacie verte : trésors de la nature</h2>
            <p>Depuis des millénaires, les plantes médicinales soignent et soulagent. Voici un guide des essentiels à avoir chez soi.</p>
            
            <h3>Les indispensables de l\'armoire à pharmacie</h3>
            
            <h4>1. La camomille (Matricaria chamomilla)</h4>
            <p><strong>Propriétés :</strong> Calmante, anti-inflammatoire, digestive</p>
            <p><strong>Utilisations :</strong> Insomnie, stress, digestions difficiles, irritations cutanées</p>
            <p><strong>Préparation :</strong> Infusion 1 cuillère à café par tasse, 10 minutes</p>
            
            <h4>2. Le gingembre (Zingiber officinale)</h4>
            <p><strong>Propriétés :</strong> Anti-nauséeux, anti-inflammatoire, stimulant</p>
            <p><strong>Utilisations :</strong> Nausées, maux de tête, inflammations, fatigue</p>
            <p><strong>Préparation :</strong> Râper frais en infusion, ou en poudre dans les plats</p>
            
            <h4>3. L\'ail (Allium sativum)</h4>
            <p><strong>Propriétés :</strong> Antibactérien, antiviral, antioxydant</p>
            <p><strong>Utilisations :</strong> Infections, hypertension, système immunitaire</p>
            <p><strong>Préparation :</strong> 1-2 gousses crues par jour, ou cuites dans les plats</p>
            
            <h4>4. Le curcuma (Curcuma longa)</h4>
            <p><strong>Propriétés :</strong> Anti-inflammatoire puissant, antioxydant</p>
            <p><strong>Utilisations :</strong> Arthrite, inflammations, digestion</p>
            <p><strong>Préparation :</strong> 1 cuillère à café avec poivre noir pour l\'absorption</p>
            
            <h4>5. La lavande (Lavandula angustifolia)</h4>
            <p><strong>Propriétés :</strong> Relaxante, antispasmodique, cicatrisante</p>
            <p><strong>Utilisations :</strong> Stress, insomnie, anxiété, brûlures légères</p>
            <p><strong>Préparation :</strong> Huile essentielle en diffusion, ou infusion pour bain</p>
            
            <h3>Précautions importantes</h3>
            <ul>
                <li>Consultez toujours un professionnel avant usage</li>
                <li>Vérifiez les contre-indications et interactions</li>
                <li>Respectez les dosages recommandés</li>
                <li>Choisissez des plantes de qualité certifiée</li>
                <li>Les femmes enceintes doivent être particulièrement prudentes</li>
            </ul>
            
            <h3>Préparation et conservation</h3>
            <p>Pour une efficacité maximale :</p>
            <ul>
                <li>Achetez des plantes bio si possible</li>
                <li>Stockez dans des contenants hermétiques à l\'abri de la lumière</li>
                <li>Préparez les infusions fraîches</li>
                <li>Respectez les temps d\'infusion</li>
            </ul>
        ',
        'featured_image_url' => 'https://images.unsplash.com/photo-1545996564-98012e888b1c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'category_id' => $categories['medecine-naturelle']->id,
        'author_id' => 1,
        'published_date' => \Carbon\Carbon::now()->subDays(11),
        'is_published' => true,
        'read_time' => 18,
    ],
    [
        'title' => 'Interview : Dr. Martin sur la prévention cardiovasculaire',
        'slug' => 'interview-dr-martin-prevention-cardiovasculaire',
        'excerpt' => 'Le cardiologue Dr. Martin partage ses conseils pour prévenir les maladies cardiovasculaires.',
        'content' => '
            <h2>Dr. Martin : 20 ans d\'expérience en cardiologie</h2>
            <p>Le Dr. Martin, cardiologue à l\'hôpital Saint-Louis, nous livre ses meilleures stratégies de prévention cardiovasculaire.</p>
            
            <h3>Les chiffres alarmants</h3>
            <p>"Les maladies cardiovasculaires restent la première cause de mortalité," souligne le Dr. Martin. "Mais 80% des cas sont évitables par des changements de mode de vie."</p>
            
            <h3>Les 5 piliers de la prévention</h3>
            
            <h4>1. L\'alimentation cœur-sain</h4>
            <p>"Le régime méditerranéen est le plus étudié et efficace," explique-t-il. "Riche en fruits, légumes, poissons, et huile d\'olive, il protège le cœur."</p>
            
            <h4>2. L\'activité physique régulière</h4>
            <p>"30 minutes de marche rapide par jour suffisent," insiste le Dr. Martin. "L\'important est la régularité plutôt que l\'intensité."</p>
            
            <h4>3. La gestion du stress</h4>
            <p>"Le stress chronique augmente la tension et l\'inflammation," prévient-il. "La méditation, le yoga, ou même de simples pauses respiratoires aident."</p>
            
            <h4>4. Le sommeil de qualité</h4>
            <p>"7-8 heures par nuit sont essentielles," souligne-t-il. "Le manque de sommeil augmente les risques d\'hypertension et de diabète."</p>
            
            <h4>5. L\'arrêt du tabac</h4>
            <p>"Le tabac est l\'ennemi numéro un du cœur," affirme-t-il. "Arrêter de fumer est la décision la plus bénéfique que vous puissiez prendre."</p>
            
            <h3>Les examens de dépistage</h3>
            <p>Le Dr. Martin recommande :</p>
            <ul>
                <li>Tension artérielle annuelle dès 40 ans</li>
                <li>Bilan lipidique tous les 5 ans</li>
                <li>Glycémie à jeun régulière</li>
                <li>ECG si facteurs de risque familiaux</li>
            </ul>
            
            <h3>Les signes d\'alerte</h3>
            <p>"Consultez immédiatement en cas de :</p>
            <ul>
                <li>Douleur thoracique persistante</li>
                <li>Essoufflement anormal</li>
                <li>Palpitations nouvelles</li>
                <li>Malaises ou vertiges inexpliqués</li>
            </ul>
            
            <h3>Message final</h3>
            <p>"La prévention est le meilleur traitement," conclut le Dr. Martin. "Prenez soin de votre cœur aujourd\'hui, il vous le rendra au centuple."</p>
        ',
        'featured_image_url' => 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
        'category_id' => $categories['interview']->id,
        'author_id' => 1,
        'published_date' => \Carbon\Carbon::now()->subDays(12),
        'is_published' => true,
        'read_time' => 14,
    ],
];

// Create articles
echo "Creating additional articles...\n";
foreach ($additionalArticles as $articleData) {
    $article = \App\Models\Article::updateOrCreate(
        ['slug' => $articleData['slug']],
        $articleData
    );
    echo "✓ Created: " . $article->title . " (ID: " . $article->id . ")\n";
}

echo "\n=== Additional Articles Created ===\n";
$totalArticles = \App\Models\Article::count();
echo "Total articles in database: " . $totalArticles . "\n";

echo "\n=== Complete ===\n";

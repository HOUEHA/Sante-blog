<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use Carbon\Carbon;

class ArticleSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $nutritionCategory = Category::where('slug', 'nutrition-alimentation')->first();
        $preventionCategory = Category::where('slug', 'prevention-bien-etre')->first();
        $santeMentaleCategory = Category::where('slug', 'sante-mentale')->first();
        $exerciceCategory = Category::where('slug', 'exercice-fitness')->first();
        $puericultureCategory = Category::where('slug', 'puericulture')->first();

        $articles = [
            [
                'title' => 'Les bienfaits des légumes verts sur votre santé',
                'slug' => 'bienfaits-legumes-verts',
                'excerpt' => 'Découvrez comment les légumes verts peuvent transformer votre alimentation et améliorer votre bien-être quotidien.',
                'content' => $this->getArticleContent('legumes-verts'),
                'featured_image_url' => 'https://images.unsplash.com/photo-1540420773790-b4a5382dcd29?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'category_id' => $nutritionCategory->id,
                'author_id' => 1,
                'published_date' => Carbon::now()->subDays(2),
                'is_published' => true,
                'read_time' => 5,
            ],
            [
                'title' => 'Méditation : 10 minutes par jour pour un esprit sain',
                'slug' => 'meditation-10-minutes',
                'excerpt' => 'Une pratique simple mais puissante pour réduire le stress et améliorer votre concentration.',
                'content' => $this->getArticleContent('meditation'),
                'featured_image_url' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'category_id' => $santeMentaleCategory->id,
                'author_id' => 1,
                'published_date' => Carbon::now()->subDays(3),
                'is_published' => true,
                'read_time' => 7,
            ],
            [
                'title' => 'Le sommeil réparateur : clé d\'une bonne santé',
                'slug' => 'sommeil-reparateur',
                'excerpt' => 'Comprendre l\'importance d\'un sommeil de qualité et comment améliorer vos nuits.',
                'content' => $this->getArticleContent('sommeil'),
                'featured_image_url' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'category_id' => $preventionCategory->id,
                'author_id' => 1,
                'published_date' => Carbon::now()->subDays(4),
                'is_published' => true,
                'read_time' => 6,
            ],
            [
                'title' => 'L\'importance des fibres dans votre alimentation quotidienne',
                'slug' => 'importance-fibres-alimentation',
                'excerpt' => 'Comprendre pourquoi les fibres sont essentielles pour votre santé digestive et globale.',
                'content' => $this->getArticleContent('fibres'),
                'featured_image_url' => 'https://images.unsplash.com/photo-1542838132-965f6533bf4d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'category_id' => $nutritionCategory->id,
                'author_id' => 1,
                'published_date' => Carbon::now()->subDays(1),
                'is_published' => true,
                'read_time' => 6,
            ],
            [
                'title' => 'Gérer le stress au quotidien : techniques efficaces',
                'slug' => 'gestion-stress-quotidien',
                'excerpt' => 'Des stratégies pratiques pour réduire le stress et améliorer votre qualité de vie.',
                'content' => $this->getArticleContent('stress'),
                'featured_image_url' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'category_id' => $santeMentaleCategory->id,
                'author_id' => 1,
                'published_date' => Carbon::now()->subDays(5),
                'is_published' => true,
                'read_time' => 8,
            ],
            [
                'title' => 'L\'exercice physique : combien de temps par semaine ?',
                'slug' => 'exercice-physique-semaine',
                'excerpt' => 'Les recommandations officielles et comment intégrer l\'activité physique dans votre routine.',
                'content' => $this->getArticleContent('exercice'),
                'featured_image_url' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'category_id' => $exerciceCategory->id,
                'author_id' => 1,
                'published_date' => Carbon::now()->subDays(6),
                'is_published' => true,
                'read_time' => 7,
            ],
            [
                'title' => 'La diversification alimentaire du nourrisson',
                'slug' => 'diversification-alimentaire-nourrisson',
                'excerpt' => 'Guide complet pour introduire les aliments solides dans l\'alimentation de bébé.',
                'content' => $this->getArticleContent('diversification'),
                'featured_image_url' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'category_id' => $puericultureCategory->id,
                'author_id' => 1,
                'published_date' => Carbon::now()->subDays(7),
                'is_published' => true,
                'read_time' => 10,
            ],
            [
                'title' => 'Les super-aliments pour renforcer votre immunité',
                'slug' => 'super-aliments-immunite',
                'excerpt' => 'Découvrez les aliments qui peuvent booster votre système immunitaire naturellement.',
                'content' => $this->getArticleContent('super-aliments'),
                'featured_image_url' => 'https://images.unsplash.com/photo-1542838132-965f6533bf4d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',
                'category_id' => $nutritionCategory->id,
                'author_id' => 1,
                'published_date' => Carbon::now()->subDays(8),
                'is_published' => true,
                'read_time' => 8,
            ],
        ];

        foreach ($articles as $article) {
            Article::updateOrCreate(
                ['slug' => $article['slug']],
                $article
            );
        }

        $this->command->info('Articles seeded successfully!');
    }

    private function getArticleContent(string $type): string
    {
        $contents = [
            'legumes-verts' => '
                <h2>Les légumes verts : des trésors pour votre santé</h2>
                <p>Les légumes verts sont souvent considérés comme les superstars de l\'alimentation saine, et pour de bonnes raisons. Riches en nutriments essentiels, faibles en calories et bénéfiques pour presque tous les aspects de notre santé.</p>
                
                <h3>Pourquoi les légumes verts sont-ils si importants ?</h3>
                <p>Ils contiennent des vitamines A, C, E et K, ainsi que des minéraux comme le fer, le calcium et le magnésium. Ces nutriments sont essentiels pour le bon fonctionnement de notre organisme.</p>
                
                <h3>Comment en consommer plus ?</h3>
                <ul>
                    <li>Ajoutez des épinards à vos smoothies du matin</li>
                    <li>Préparez des salades variées avec différents types de feuilles vertes</li>
                    <li>Intégrez des légumes verts dans vos plats principaux</li>
                    <li>Essayez les légumes verts sautés à l\'ail et à l\'huile d\'olive</li>
                </ul>
                
                <p>En intégrant régulièrement des légumes verts dans votre alimentation, vous investissez dans votre santé à long terme.</p>
            ',
            'meditation' => '
                <h2>La méditation : un outil puissant pour votre bien-être mental</h2>
                <p>Dans notre monde moderne et trépidant, la méditation offre une parenthèse essentielle pour reconnecter avec soi-même et réduire le stress accumulé.</p>
                
                <h3>Les bienfaits scientifiquement prouvés</h3>
                <p>Des études démontrent que la méditation régulière peut :</p>
                <ul>
                    <li>Réduire l\'anxiété et les symptômes de dépression</li>
                    <li>Améliorer la concentration et la clarté mentale</li>
                    <li>Abaisser la pression artérielle</li>
                    <li>Renforcer le système immunitaire</li>
                    <li>Améliorer la qualité du sommeil</li>
                </ul>
                
                <h3>Comment commencer ?</h3>
                <p>Commencez petit : 5-10 minutes par jour suffisent pour ressentir les bénéfices. Asseyez-vous dans un endroit calme, concentrez-vous sur votre respiration, et laissez vos pensées passer sans vous y accrocher.</p>
                
                <p>La régularité est la clé. Même quelques minutes chaque jour peuvent transformer votre relation au stress et améliorer considérablement votre qualité de vie.</p>
            ',
            'sommeil' => '
                <h2>Le sommeil : fondement d\'une bonne santé</h2>
                <p>Le sommeil n\'est pas un luxe, mais une nécessité biologique essentielle pour notre santé physique et mentale.</p>
                
                <h3>Pourquoi le sommeil est-il si important ?</h3>
                <p>Pendant le sommeil, notre corps :</p>
                <ul>
                    <li>Répare les tissus et les muscles</li>
                    <li>Consolide la mémoire et les apprentissages</li>
                    <li>Renforce le système immunitaire</li>
                    <li>Régule les hormones essentielles</li>
                    <li>Élimine les toxines accumulées</li>
                </ul>
                
                <h3>Conseils pour un meilleur sommeil</h3>
                <ul>
                    <li>Maintenez un horaire de coucher régulier</li>
                    <li>Créez un environnement propice au sommeil (sombre, frais, calme)</li>
                    <li>Évitez les écrans 1-2 heures avant de dormir</li>
                    <li>Limitez la caféine en fin de journée</li>
                    <li>Pratiquez une activité de relaxation avant le coucher</li>
                </ul>
                
                <p>Un sommeil de qualité n\'est pas négociable. C\'est l\'un des piliers fondamentaux d\'une vie saine et équilibrée.</p>
            ',
            'fibres' => '
                <h2>Les fibres : les héros méconnus de notre alimentation</h2>
                <p>Souvent négligées, les fibres jouent pourtant un rôle crucial dans notre santé digestive et globale.</p>
                
                <h3>Les deux types de fibres</h3>
                <p><strong>Fibres solubles :</strong> Se dissolvent dans l\'eau et aident à contrôler le cholestérol et la glycémie. On les trouve dans l\'avoine, les pommes, les carottes.</p>
                
                <p><strong>Fibres insolubles :</strong> Ne se dissolvent pas dans l\'eau et favorisent le transit intestinal. Présentes dans les céréales complètes, les noix, les légumes verts.</p>
                
                <h3>Bienfaits pour la santé</h3>
                <ul>
                    <li>Améliorent la digestion et préviennent la constipation</li>
                    <li>Aident à maintenir un poids santé</li>
                    <li>Réduisent le risque de maladies cardiaques</li>
                    <li>Contrôlent la glycémie</li>
                    <li>Nourrissent le microbiote intestinal</li>
                </ul>
                
                <h3>Comment augmenter votre apport en fibres ?</h3>
                <p>Commencez progressivement pour éviter les troubles digestifs. Intégrez des légumes, fruits, céréales complètes et légumineuses dans chaque repas.</p>
            ',
            'stress' => '
                <h2>Gérer le stress : des stratégies qui fonctionnent</h2>
                <p>Le stress chronique peut avoir des effets dévastateurs sur notre santé. Heureusement, il existe des techniques efficaces pour le gérer.</p>
                
                <h3>Techniques de relaxation immédiate</h3>
                <ul>
                    <li><strong>Respiration profonde :</strong> 5 minutes de respiration abdominale peuvent instantanément réduire le stress</li>
                    <li><strong>Relaxation musculaire progressive :</strong> Contractez puis relâchez chaque groupe musculaire</li>
                    <li><strong>Visualisation :</strong> Imaginez un lieu calme et sécurisant</li>
                    <li><strong>Méditation rapide :</strong> 2-3 minutes de pleine conscience</li>
                </ul>
                
                <h3>Stratégies à long terme</h3>
                <ul>
                    <li>Pratiquez régulièrement une activité physique</li>
                    <li>Maintenez des relations sociales de qualité</li>
                    <li>Apprenez à dire "non" et à fixer des limites</li>
                    <li>Privilégiez un équilibre vie pro/vie perso</li>
                    <li>Considérez la thérapie si le stress persiste</li>
                </ul>
                
                <p>La gestion du stress n\'est pas une option, mais une compétence essentielle pour préserver votre santé à long terme.</p>
            ',
            'exercice' => '
                <h2>L\'exercice physique : le médicament préventif par excellence</h2>
                <p>L\'activité physique régulière est l\'une des interventions les plus puissantes pour préserver et améliorer votre santé.</p>
                
                <h3>Les recommandations officielles</h3>
                <p>L\'OMS recommande :</p>
                <ul>
                    <li>150 minutes d\'activité modérée par semaine (marche rapide, natation)</li>
                    <li>Ou 75 minutes d\'activité intense par semaine (course, sports intensifs)</li>
                    <li>Plus 2 séances de renforcement musculaire par semaine</li>
                </ul>
                
                <h3>Comment intégrer l\'exercice dans votre vie ?</h3>
                <ul>
                    <li><strong>Commencez doucement :</strong> 10-15 minutes par jour suffisent pour commencer</li>
                    <li><strong>Trouvez une activité que vous aimez :</strong> Vous serez plus régulier</li>
                    <li><strong>Soyez actif au quotidien :</strong> Prenez les escaliers, marchez pour vos courses</li>
                    <li><strong>Planifiez vos séances :</strong> Comme des rendez-vous importants</li>
                    <li><strong>Variez les plaisirs :</strong> Alternez cardio, renforcement, souplesse</li>
                </ul>
                
                <p>L\'important n\'est pas l\'intensité, mais la régularité. Votre corps vous remerciera à chaque séance.</p>
            ',
            'diversification' => '
                <h2>La diversification alimentaire : un grand pas pour bébé</h2>
                <p>La diversification alimentaire est une étape cruciale dans le développement de votre enfant. Voici comment l\'aborder en toute sérénité.</p>
                
                <h3>À quel âge commencer ?</h3>
                <p>Les recommandations actuelles suggèrent de commencer entre 4 et 6 mois révolus, lorsque bébé :</p>
                <ul>
                    <li>Tient bien sa tête assis</li>
                    <li>Montre de l\'intérêt pour la nourriture</li>
                    <li>Sait ouvrir la bouche quand on lui présente une cuillère</li>
                </ul>
                
                <h3>Comment commencer ?</h3>
                <ul>
                    <li>Commencez par des légumes simples et cuits (carottes, courgettes, patates douces)</li>
                    <li>Introduisez un nouvel aliment tous les 3 jours</li>
                    <li>Proposez des textures lisses et homogènes</li>
                    <li>Respectez les goûts et les quantités de bébé</li>
                </ul>
                
                <h3>Les aliments à éviter</h3>
                <p>Pendant la première année, évitez : miel, fruits de mer, produits laitiers non adaptés, et les aliments trop salés ou sucrés.</p>
                
                <p>Chaque bébé est unique. Suivez son rythme et consultez votre pédiatre en cas de doute.</p>
            ',
            'super-aliments' => '
                <h2>Les super-aliments : boostez votre immunité naturellement</h2>
                <p>Certains aliments sont particulièrement riches en nutriments qui peuvent renforcer votre système immunitaire et vous protéger contre les infections.</p>
                
                <h3>Le top 5 des super-aliments immunitaires</h3>
                
                <h4>1. L\'ail</h4>
                <p>Riche en allicine, l\'ail possède des propriétés antibactériennes et antivirales puissantes. Consommez-en cru ou légèrement cuit pour maximiser ses bienfaits.</p>
                
                <h4>2. Le gingembre</h4>
                <p>Anti-inflammatoire naturel, le gingembre aide à combattre les infections et à réduire l\'inflammation. Excellent en infusion ou dans vos plats.</p>
                
                <h4>3. Les agrumes</h4>
                <p>Riches en vitamine C, les oranges, citrons et pamplemousses stimulent la production de globules blancs, essentiels pour combattre les infections.</p>
                
                <h4>4. Les baies</h4>
                <p>Myrtilles, fraises, framboises sont chargées d\'antioxydants qui protègent vos cellules et renforcent votre système immunitaire.</p>
                
                <h4>5. Le curcuma</h4>
                <p>La curcumine, son principe actif, est un puissant anti-inflammatoire. Associez-la au poivre noir pour une meilleure absorption.</p>
                
                <h3>Comment les intégrer ?</h3>
                <p>Ajoutez ces aliments progressivement dans votre alimentation quotidienne. Une cuillère de curcuma dans vos soupes, de l\'ail dans vos sauces, des baies dans vos petit-déjeuners...</p>
                
                <p>Une alimentation variée et riche en ces super-aliments est votre meilleure assurance santé naturelle.</p>
            ',
        ];

        return $contents[$type] ?? 'Contenu de l\'article...';
    }
}

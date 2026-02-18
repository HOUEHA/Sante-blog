<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FAQ;

class FAQSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $faqs = [
            // Nutrition et Alimentation
            [
                'question' => 'Quels sont les aliments les plus nutritifs pour la santé ?',
                'answer' => 'Les aliments les plus nutritifs incluent les légumes verts à feuilles (épinards, kale), les baies riches en antioxydants, les poissons gras riches en oméga-3, les légumineuses pour les protéines et fibres, les noix et graines pour les bons gras, et les céréales complètes pour les vitamines et minéraux. Ces aliments fournissent un large éventail de nutriments essentiels pour une santé optimale.',
                'category' => 'Nutrition et Alimentation',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'question' => 'Combien de litres d\'eau devrais-je boire par jour ?',
                'answer' => 'En général, il est recommandé de boire environ 1,5 à 2 litres d\'eau par jour. Cependant, vos besoins peuvent varier selon votre niveau d\'activité physique, le climat, votre âge et votre état de santé. Les personnes très actives ou vivant dans des climats chauds peuvent avoir besoin de plus. Écoutez votre corps et buvez lorsque vous avez soif.',
                'category' => 'Nutrition et Alimentation',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'question' => 'Les régimes végétariens sont-ils sains ?',
                'answer' => 'Oui, un régime végétarien bien planifié peut être très sain. Il peut réduire le risque de maladies cardiaques, de diabète de type 2 et de certains cancers. Cependant, il est important de s\'assurer d\'obtenir suffisamment de protéines, de fer, de calcium et de vitamine B12, souvent par les légumineuses, les produits céréaliers enrichis, les légumes verts et les suppléments si nécessaire.',
                'category' => 'Nutrition et Alimentation',
                'is_active' => true,
                'sort_order' => 3,
            ],

            // Santé mentale
            [
                'question' => 'Comment pratiquer la méditation pour débutants ?',
                'answer' => 'Pour débuter la méditation : asseyez-vous confortablement, fermez les yeux, et concentrez-vous sur votre respiration. Commencez par 5-10 minutes par jour. Utilisez des applications guidées ou des vidéos en ligne. La régularité est plus importante que la durée. Soyez patient avec vous-même et ne jugez pas vos pensées.',
                'category' => 'Santé mentale',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'question' => 'Quand faut-il consulter un psychologue ?',
                'answer' => 'Il est recommandé de consulter un psychologue lorsque vous ressentez une détresse émotionnelle persistante, des difficultés relationnelles, des troubles du sommeil ou de l\'appétit, ou lorsque vous traversez une période difficile. N\'hésitez pas à demander de l\'aide, c\'est un signe de force.',
                'category' => 'Santé mentale',
                'is_active' => true,
                'sort_order' => 2,
            ],

            // Prévention et Bien-être
            [
                'question' => 'Combien d\'heures de sommeil sont nécessaires ?',
                'answer' => 'Les adultes ont besoin de 7-9 heures de sommeil par nuit. Les enfants et adolescents ont besoin de plus (9-11 heures). Un sommeil de qualité est essentiel pour la récupération physique, la santé mentale, et le bon fonctionnement du système immunitaire.',
                'category' => 'Prévention et Bien-être',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'question' => 'Quels sont les signes du stress chronique ?',
                'answer' => 'Les signes du stress chronique incluent la fatigue persistante, les maux de tête fréquents, les troubles du sommeil, l\'irritabilité, les problèmes de concentration, les tensions musculaires, et les changements d\'appétit. Il est important de consulter un professionnel si ces symptômes persistent.',
                'category' => 'Prévention et Bien-être',
                'is_active' => true,
                'sort_order' => 2,
            ],

            // Exercice et Fitness
            [
                'question' => 'Quel type d\'exercice pour perdre du poids ?',
                'answer' => 'Pour perdre du poids efficacement, combinez des exercices cardio (course, vélo, natation) 3-4 fois par semaine avec des exercices de renforcement musculaire 2-3 fois par semaine. L\'important est la régularité et de trouver des activités que vous aimez pour maintenir la motivation à long terme.',
                'category' => 'Exercice et Fitness',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'question' => 'Combien de temps d\'exercice par semaine ?',
                'answer' => 'L\'OMS recommande au moins 150 minutes d\'exercice modéré par semaine (30 minutes, 5 jours) ou 75 minutes d\'exercice intense. Ajoutez 2 jours de renforcement musculaire. L\'important est d\'être régulier plutôt que parfait.',
                'category' => 'Exercice et Fitness',
                'is_active' => true,
                'sort_order' => 2,
            ],

            // Puériculture
            [
                'question' => 'À quel âge commencer la diversification alimentaire ?',
                'answer' => 'La diversification alimentaire commence généralement entre 4 et 6 mois, quand bébé tient bien sa tête et s\'intéresse à la nourriture. Commencez par des légumes cuits et mixés, un par un, en attendant 3 jours entre chaque nouvel aliment.',
                'category' => 'Puériculture',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'question' => 'Combien de temps un bébé doit-il dormir ?',
                'answer' => 'Les besoins en sommeil varient avec l\'âge: nouveau-nés (0-3 mois): 14-17 heures, bébés (4-11 mois): 12-16 heures, toddlers (1-2 ans): 11-14 heures. Chaque bébé est différent, respectez son rythme.',
                'category' => 'Puériculture',
                'is_active' => true,
                'sort_order' => 2,
            ],

            // Maladies chroniques
            [
                'question' => 'Comment gérer le diabète au quotidien ?',
                'answer' => 'La gestion du diabète inclut la surveillance régulière de la glycémie, une alimentation équilibrée, l\'activité physique régulière, la prise médicamenteuse conforme, et le suivi médical régulier. L\'éducation du patient et le soutien familial sont essentiels.',
                'category' => 'Maladies chroniques',
                'is_active' => true,
                'sort_order' => 1,
            ],

            // Médecine naturelle
            [
                'question' => 'Quelles plantes pour soulager le stress ?',
                'answer' => 'Plusieurs plantes peuvent aider: la camomille (calmante), la lavande (relaxante), le millepertuis (dépression légère), la valériane (sommeil), et le thé vert (antioxydant). Consultez toujours un professionnel avant usage, surtout si vous prenez des médicaments.',
                'category' => 'Médecine naturelle',
                'is_active' => true,
                'sort_order' => 1,
            ],
        ];

        foreach ($faqs as $faq) {
            FAQ::updateOrCreate(
                ['question' => $faq['question']],
                $faq
            );
        }

        $this->command->info('FAQs seeded successfully!');
    }
}

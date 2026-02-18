<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $categories = [
            [
                'name' => 'Nutrition et Alimentation',
                'slug' => 'nutrition-alimentation',
                'description' => 'Conseils sur une alimentation saine et équilibrée pour une meilleure santé',
                'color' => '#10B981',
                'icon' => 'utensils',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Prévention et Bien-être',
                'slug' => 'prevention-bien-etre',
                'description' => 'Stratégies de prévention et conseils pour améliorer votre bien-être quotidien',
                'color' => '#3B82F6',
                'icon' => 'heart',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Santé mentale',
                'slug' => 'sante-mentale',
                'description' => 'Gestion du stress, méditation et santé psychologique',
                'color' => '#8B5CF6',
                'icon' => 'brain',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Exercice et Fitness',
                'slug' => 'exercice-fitness',
                'description' => 'Programmes d\'exercice, fitness et activités physiques',
                'color' => '#EF4444',
                'icon' => 'dumbbell',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Interview et témoignage',
                'slug' => 'interview-temoignage',
                'description' => 'Témoignages et interviews d\'experts de la santé',
                'color' => '#F59E0B',
                'icon' => 'microphone',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Puériculture',
                'slug' => 'puericulture',
                'description' => 'Conseils pour la santé et le bien-être des enfants',
                'color' => '#EC4899',
                'icon' => 'baby',
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Maladies chroniques',
                'slug' => 'maladies-chroniques',
                'description' => 'Information et gestion des maladies chroniques',
                'color' => '#6B7280',
                'icon' => 'stethoscope',
                'is_active' => true,
                'sort_order' => 7,
            ],
            [
                'name' => 'Médecine naturelle',
                'slug' => 'medecine-naturelle',
                'description' => 'Remèdes naturels et médecines alternatives',
                'color' => '#059669',
                'icon' => 'leaf',
                'is_active' => true,
                'sort_order' => 8,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        $this->command->info('Categories seeded successfully!');
    }
}

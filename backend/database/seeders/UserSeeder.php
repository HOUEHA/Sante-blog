<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'constant.houeha@gmail.com'],
            [
                'name' => 'Constant Houeha',
                'email' => 'constant.houeha@gmail.com',
                'password' => Hash::make('password@123'),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create test users
        $testUsers = [
            [
                'name' => 'Marie Dupont',
                'email' => 'marie.dupont@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Jean Martin',
                'email' => 'jean.martin@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'is_active' => true,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Sophie Laurent',
                'email' => 'sophie.laurent@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'is_active' => false, // Inactive user for testing
                'email_verified_at' => now(),
            ],
        ];

        foreach ($testUsers as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }

        $this->command->info('Users seeded successfully!');
    }
}

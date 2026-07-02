<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            EscortSeeder::class,
            SettingsSeeder::class,
            LocationsSeeder::class,
            ContactMessageSeeder::class,
            EstablishmentSeeder::class,
        ]);


        // Admin
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@citasescort.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // User
        User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@citasescort.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        // Escort
        $escortUser = User::factory()->create([
            'name' => 'Escort User',
            'email' => 'escort@citasescort.com',
            'password' => bcrypt('password'),
            'role' => 'escort',
        ]);

        // Create Escort Profile
        $escortUser->escort()->create([
            'name' => 'Valentina',
            'description' => 'Escort profesional con experiencia.',
            'age' => 25,
            'city' => 'Lima',
            'price' => 2500.00,
            'is_active' => true,
        ]);

        // Casas de Masajes
        for ($i = 1; $i <= 5; $i++) {
            User::factory()->create([
                'name' => "Casa de Masajes $i",
                'email' => "casamasajes$i@citasescort.com",
                'password' => bcrypt('password'),
                'role' => 'casa de masajes',
            ]);
        }
    }
}


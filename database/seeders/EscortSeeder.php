<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Escort;
use App\Models\Story;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class EscortSeeder extends Seeder
{
    public function run(): void
    {
        // Define exact counts per level and gender to ensure a rich database
        $distribution = [
            'diamante' => [
                'female' => 8,
            ],
            'plata' => [
                'female' => 16,
            ],
            'general' => [
                'female' => 25,
            ],
        ];

        foreach ($distribution as $level => $genders) {
            foreach ($genders as $gender => $count) {
                User::factory($count)->create(['role' => 'escort'])->each(function ($user) use ($level, $gender) {
                    $avatarSeed = $user->name . rand(1, 1000);
                    
                    // Determine name style based on gender
                    $nameGender = $gender === 'male' ? 'male' : 'female';
                    
                    $escort = Escort::factory()->create([
                        'user_id' => $user->id,
                        'name' => fake()->firstName($nameGender), // Ensure name matches gender
                        'level' => $level,
                        'gender' => $gender, // Explicitly set gender
                        'is_active' => true,
                    ]);

                    // Create Stories (Same logic as before)
                    for ($i = 0; $i < rand(6, 10); $i++) {
                        $seed = $user->id . '-' . $i;
                        $storyUrl = "https://picsum.photos/seed/{$seed}/800/1200";
                        
                        $captions = [
                            'Disfrutando de la noche 🌙', 'Lista para salir 🎉', 'Relax total 🧖', 'Cena especial 🥂', 
                            'Te espero... 🔥', 'Nuevo look 💇', 'Atardecer 🌅', 'Gym 💪', 'Disponible 💋', 'Hola a todos 👋'
                        ];

                        Story::create([
                            'escort_id' => $escort->id,
                            'media_path' => $storyUrl, 
                            'media_type' => 'image',
                            'caption' => $captions[array_rand($captions)],
                            'is_active' => true,
                            'expires_at' => now()->addHours(24),
                        ]);
                    }
                });
            }
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Escort;
use App\Models\Story;

class StorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar historias viejas
        Story::truncate();

        $images = [
            'https://images.unsplash.com/photo-1529626455594-4ff0802cfb7e?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1502823403499-6ccfcf4fb453?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1529139574466-a303027c028b?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1514315384763-ba401779410f?auto=format&fit=crop&w=800&q=80',
            'https://images.unsplash.com/photo-1488426862026-3ee34a7d66df?auto=format&fit=crop&w=800&q=80'
        ];

        $captions = [
            'Disponible hoy!',
            'Besitos a todos 😘',
            'Nueva lencería ✨',
            'Esperándote...',
            'Promo esta noche 🔥'
        ];

        // Assign random profile photos to ALL active escorts so they have bubbles
        $allEscorts = Escort::where('is_active', true)->get();
        foreach ($allEscorts as $escort) {
            if (empty($escort->profile_photo)) {
                $escort->profile_photo = $images[array_rand($images)];
                $escort->save();
            }
        }

        // Obtener 25 escorts aleatorias para crear historias
        $escorts = Escort::where('is_active', true)->inRandomOrder()->take(25)->get();

        foreach ($escorts as $escort) {
            $numStories = rand(1, 3);
            
            for ($i = 0; $i < $numStories; $i++) {
                Story::create([
                    'escort_id' => $escort->id,
                    'media_path' => [$images[array_rand($images)]],
                    'media_type' => 'image',
                    'caption' => $captions[array_rand($captions)],
                    'is_active' => true,
                    'expires_at' => now()->addHours(24),
                ]);
            }
        }
    }
}

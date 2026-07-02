<?php

namespace Database\Seeders;

use App\Models\Escort;
use App\Models\Story;
use Illuminate\Database\Seeder;

class ForceStoriesSeeder extends Seeder
{
    public function run(): void
    {
        // Get active Diamond/Silver escorts
        $escorts = Escort::where('is_active', true)->take(15)->get();

        foreach ($escorts as $escort) {
            // Add 2 brand new stories
            for ($i = 0; $i < 2; $i++) {
                 Story::create([
                    'escort_id' => $escort->id,
                    'media_path' => 'https://ui-avatars.com/api/?name=' . urlencode($escort->name) . '&background=random&size=800&length=1&font-size=0.33&bold=true',
                    'media_type' => 'image',
                    'caption' => 'Historia Nueva ' . now()->format('H:i') . ' 🔥',
                    'is_active' => true,
                    'expires_at' => now()->addHours(24), // 24 hours from now
                    'created_at' => now(),
                ]);
            }
        }
        
        $this->command->info('Freshest stories created for ' . $escorts->count() . ' escorts.');
    }
}

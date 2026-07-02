<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Story;

class UpdateStoriesSeeder extends Seeder
{
    public function run(): void
    {
        $stories = Story::all();
        $i = 1;
        foreach($stories as $story) { 
            // Using picsum to get random realistic portrait images for stories
            // Adding a unique seed so each story image is different, but consistent if re-loaded
            $seed = $story->id . '-' . $i;
            $story->media_path = "https://picsum.photos/seed/{$seed}/800/1200";
            $story->save(); 
            $i++;
        }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Story;
use Illuminate\Support\Facades\Storage;

class CleanupStories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stories:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes expired stories and their associated media files from storage.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get stories where expires_at is in the past
        // We use withoutGlobalScope to find them since they are hidden by default
        $expiredStories = Story::withoutGlobalScope('active_expiration')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', now())
            ->get();

        $count = 0;

        foreach ($expiredStories as $story) {
            // Delete files
            $paths = $story->media_path;
            if (is_string($paths)) {
                $paths = [$paths];
            }
            
            if (is_array($paths)) {
                foreach ($paths as $path) {
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }
            }

            // Delete from database
            $story->delete();
            $count++;
        }

        $this->info("Successfully deleted {$count} expired stories.");
    }
}

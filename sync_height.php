<?php

use App\Models\Escort;
use App\Models\Publication;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$escort = Escort::find(51);
$publication = Publication::where('escort_id', 51)->first();

if ($escort && $publication) {
    echo "=== CURRENT DATA ===\n";
    echo "Escort Height: " . ($escort->height ?? 'NULL') . "\n";
    echo "Publication Height: " . ($publication->height ?? 'NULL') . "\n\n";
    
    echo "=== SYNCING ===\n";
    $escort->height = $publication->height;
    $escort->save();
    
    echo "Escort Height (after sync): " . ($escort->height ?? 'NULL') . "\n";
    echo "✓ Height synced successfully!\n";
} else {
    echo "Error: Escort or Publication not found.\n";
}

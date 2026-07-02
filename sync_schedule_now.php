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
    echo "Syncing schedule from Publication to Escort...\n";
    echo "Publication Schedule: " . ($publication->schedule ?? 'NULL') . "\n";
    
    $escort->schedule = $publication->schedule;
    $escort->save();
    
    echo "Escort Schedule (after sync): " . ($escort->schedule ?? 'NULL') . "\n";
    echo "✓ Sync complete!\n";
} else {
    echo "Error: Escort or Publication not found.\n";
}

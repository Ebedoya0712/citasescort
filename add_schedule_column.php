<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    // Add schedule column to escorts table
    DB::statement('ALTER TABLE escorts ADD COLUMN schedule TEXT NULL AFTER attends_to');
    echo "✓ Column 'schedule' added to escorts table\n";
} catch (\Exception $e) {
    if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
        echo "✓ Column 'schedule' already exists\n";
    } else {
        echo "Error: " . $e->getMessage() . "\n";
        exit(1);
    }
}

// Now sync the data
$escort = App\Models\Escort::find(51);
$publication = App\Models\Publication::where('escort_id', 51)->first();

if ($escort && $publication) {
    echo "\nSyncing schedule from Publication to Escort...\n";
    echo "Publication Schedule: " . ($publication->schedule ?? 'NULL') . "\n";
    
    $escort->schedule = $publication->schedule;
    $escort->save();
    
    echo "Escort Schedule (after sync): " . ($escort->schedule ?? 'NULL') . "\n";
    echo "✓ Sync complete!\n";
} else {
    echo "\nError: Escort or Publication not found.\n";
}

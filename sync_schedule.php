<?php

use App\Models\Escort;
use Illuminate\Support\Facades\Auth;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$escort = Escort::with('publications')->find(51);

if ($escort && $publication = $escort->publications->first()) {
    echo "Syncing schedule for Escort ID: " . $escort->id . "\n";
    echo "Publication Schedule: " . ($publication->schedule ?? 'NULL') . "\n";
    
    $escort->update([
        'schedule' => $publication->schedule,
    ]);
    
    echo "Schedule sync complete.\n";
} else {
    echo "Escort or Publication not found.\n";
}

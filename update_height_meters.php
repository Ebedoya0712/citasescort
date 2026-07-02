<?php

use App\Models\Escort;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$escort = Escort::find(51);

if ($escort) {
    echo "Current Height: " . ($escort->height ?? 'NULL') . "\n";
    
    // Update height to 1.75 m
    $escort->height = 1.75;
    $escort->save();
    
    echo "New Height: " . $escort->height . " m\n";
    echo "✓ Height updated successfully!\n";
} else {
    echo "Escort not found.\n";
}

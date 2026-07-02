<?php

use App\Models\Escort;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$escort = Escort::find(51);

if ($escort) {
    echo "=== ESCORT DATA ===\n";
    echo "ID: " . $escort->id . "\n";
    echo "Name: " . $escort->name . "\n";
    echo "Description: " . ($escort->description ?? 'NULL') . "\n\n";
    
    echo "=== SERVICES ===\n";
    if (!empty($escort->services)) {
        print_r($escort->services);
    } else {
        echo "No services found\n";
    }
} else {
    echo "Escort not found.\n";
}

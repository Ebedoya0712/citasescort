<?php

use App\Models\Escort;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$escort = Escort::find(51);

if ($escort) {
    echo "Escort ID: " . $escort->id . "\n";
    echo "Name: " . $escort->name . "\n";
    echo "Height: " . ($escort->height ?? 'NULL') . "\n";
    echo "Age: " . ($escort->age ?? 'NULL') . "\n";
    echo "Gender: " . ($escort->gender ?? 'NULL') . "\n";
    echo "Hair Color: " . ($escort->hair_color ?? 'NULL') . "\n";
} else {
    echo "Escort not found.\n";
}

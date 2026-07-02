<?php

use App\Models\Escort;
use App\Models\Publication;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$escort = Escort::find(51);
$publication = Publication::where('escort_id', 51)->first();

echo "=== ESCORT DATA ===\n";
echo "Schedule: " . ($escort->schedule ?? 'NULL') . "\n\n";

echo "=== PUBLICATION DATA ===\n";
echo "Schedule: " . ($publication->schedule ?? 'NULL') . "\n";

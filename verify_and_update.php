<?php

use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== CHECKING COLUMN TYPE ===\n";
$columns = DB::select("DESCRIBE escorts");
foreach ($columns as $column) {
    if ($column->Field === 'height') {
        echo "Height column type: " . $column->Type . "\n\n";
    }
}

echo "=== CURRENT VALUE ===\n";
$current = DB::select("SELECT id, height FROM escorts WHERE id = 51");
echo "Escort 51 height: " . $current[0]->height . "\n\n";

echo "=== FORCING UPDATE ===\n";
DB::statement("UPDATE escorts SET height = 1.75 WHERE id = 51");

echo "=== VERIFYING ===\n";
$updated = DB::select("SELECT id, height FROM escorts WHERE id = 51");
echo "Escort 51 height after update: " . $updated[0]->height . "\n";
echo "✓ Complete!\n";

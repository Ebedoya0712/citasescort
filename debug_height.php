<?php

use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Checking column type...\n";
$columns = DB::select("DESCRIBE escorts");
foreach ($columns as $column) {
    if ($column->Field === 'height') {
        echo "Height column type: " . $column->Type . "\n";
    }
}

echo "\nUpdating height...\n";
$affected = DB::update("UPDATE escorts SET height = ? WHERE id = ?", [1.75, 51]);
echo "Rows affected: " . $affected . "\n";

// Verify
$result = DB::select("SELECT height FROM escorts WHERE id = 51");
echo "Current height: " . $result[0]->height . "\n";

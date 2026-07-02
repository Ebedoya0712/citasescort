<?php

use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Altering height column to DECIMAL...\n";

try {
    DB::statement("ALTER TABLE escorts MODIFY COLUMN height DECIMAL(3,2) NULL");
    echo "✓ Column type changed to DECIMAL(3,2)\n\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n\n";
}

echo "Updating height to 1.75...\n";
$affected = DB::update("UPDATE escorts SET height = ? WHERE id = ?", [1.75, 51]);
echo "Rows affected: " . $affected . "\n";

// Verify
$result = DB::select("SELECT height FROM escorts WHERE id = 51");
echo "Current height: " . $result[0]->height . " m\n";
echo "✓ Done!\n";

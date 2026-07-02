<?php

use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Step 1: Changing height column to VARCHAR...\n";
try {
    DB::statement("ALTER TABLE escorts MODIFY COLUMN height VARCHAR(10) NULL");
    echo "✓ Column changed to VARCHAR(10)\n\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n\n";
}

echo "Step 2: Updating height value...\n";
DB::statement("UPDATE escorts SET height = '1.75' WHERE id = 51");
echo "✓ Height updated\n\n";

echo "Step 3: Verifying...\n";
$result = DB::select("SELECT height FROM escorts WHERE id = 51");
echo "Current height: " . $result[0]->height . " m\n";

$columns = DB::select("DESCRIBE escorts");
foreach ($columns as $column) {
    if ($column->Field === 'height') {
        echo "Column type: " . $column->Type . "\n";
    }
}

echo "\n✓ Complete!\n";

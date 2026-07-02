<?php

use App\Models\Publication;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$publications = Publication::all();
foreach ($publications as $pub) {
    echo "ID: " . $pub->id . "\n";
    echo "Gender: " . var_export($pub->gender, true) . "\n";
    echo "Age: " . var_export($pub->age, true) . "\n";
    echo "City: " . var_export($pub->city, true) . "\n";
    echo "-------------------\n";
}

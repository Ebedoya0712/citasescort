<?php

use App\Models\Publication;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$pub = Publication::find(1);
if ($pub) {
    $pub->gender = 'Mujer';
    $pub->save();
    echo "Updated ID 1 gender to 'Mujer'.\n";
    
    $pub->refresh();
    echo "New Gender: " . var_export($pub->gender, true) . "\n";
} else {
    echo "Publication 1 not found.\n";
}

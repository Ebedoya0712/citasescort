<?php

use App\Models\Escort;
use App\Models\Publication;
use Illuminate\Support\Facades\Auth;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Inspecting Escort ID 51 as seen in the user's screenshot URL
$escort = Escort::with('publications')->find(51); 

if ($escort) {
    echo "Escort ID: " . $escort->id . "\n";
    echo "Escort Name: " . $escort->name . "\n";
    echo "Escort Age: " . $escort->age . "\n";
    echo "Escort Gender: " . $escort->gender . "\n";
    echo "Escort Price: " . $escort->price . "\n";
    echo "Escort Attends In: " . var_export($escort->attends_in, true) . "\n";
    
    if ($escort->publications->isNotEmpty()) {
        $pub = $escort->publications->first();
        echo "\n--- Linked Publication ---\n";
        echo "Publication ID: " . $pub->id . "\n";
        echo "Publication Age: " . $pub->age . "\n";
        echo "Publication Gender: " . $pub->gender . "\n";
        echo "Publication Price: " . $pub->price . "\n";
        echo "Publication Attends In: " . var_export($pub->attends_in, true) . "\n";
    } else {
        echo "\nNo linked publications found.\n";
    }
} else {
    echo "No escorts found.\n";
}

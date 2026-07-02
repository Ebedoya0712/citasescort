<?php

use App\Models\Escort;
use Illuminate\Support\Facades\Auth;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$escort = Escort::with('publications')->find(51);

if ($escort && $publication = $escort->publications->first()) {
    echo "Syncing data for Escort ID: " . $escort->id . "\n";
    echo "Old Age: " . $escort->age . " -> New Age: " . $publication->age . "\n";
    echo "Old Price: " . $escort->price . " -> New Price: " . $publication->price . "\n";
    
    $escort->update([
        'title' => $publication->title,
        'description' => $publication->description,
        'photos' => $publication->photos,
        'price' => $publication->price,
        'city' => $publication->city,
        'oral_sex' => $publication->oral_sex,
        'fantasies' => $publication->fantasies,
        'virtual_services' => $publication->virtual_services,
        'age' => $publication->age,
        'gender' => $publication->gender,
        'height' => $publication->height,
        'hair_color' => $publication->hair_color,
        'phone' => $publication->phone,
        'whatsapp' => $publication->whatsapp,
        'instagram' => $publication->instagram,
        'twitter' => $publication->twitter,
        'onlyfans' => $publication->onlyfans,
        'attends_in' => $publication->attends_in,
        'attends_to' => $publication->attends_to,
        'services' => $publication->services,
    ]);
    
    echo "Sync complete.\n";
} else {
    echo "Escort or Publication not found.\n";
}

<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Establishment;
use Illuminate\Support\Str;

$establishments = Establishment::all();
foreach ($establishments as $est) {
    if ($est->id !== 10) { // Don't mess with user's Establishment 69
        if (Str::startsWith($est->cover_image, 'http')) {
            // Move cover_image to banner_image
            $est->banner_image = $est->cover_image;
            // Generate a cool initial logo using ui-avatars
            $est->cover_image = 'https://ui-avatars.com/api/?name=' . urlencode($est->name) . '&background=random&size=400';
            $est->save();
        }
    }
}
echo "Images fixed.\n";

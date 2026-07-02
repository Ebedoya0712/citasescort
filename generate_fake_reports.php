<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

// Create directory if it doesn't exist
Storage::disk('public')->makeDirectory('reports/evidence');

// Get some users
$regularUser = User::where('role', 'user')->first();
$escortUser = User::where('role', 'escort')->first();

if (!$regularUser || !$escortUser) {
    echo "No hay suficientes usuarios para crear reportes falsos." . PHP_EOL;
    exit;
}

// Dummy image URLs to download
$imageUrls = [
    'https://picsum.photos/400/400?random=1',
    'https://picsum.photos/400/400?random=2',
    'https://picsum.photos/400/400?random=3'
];

$reasons = [
    'Perfil falso o fotos robadas',
    'Comportamiento inapropiado o acoso',
    'Spam o estafa',
];

$descriptions = [
    'Las fotos no corresponden con la persona que se presentó.',
    'Me ha estado enviando mensajes inapropiados insistentemente.',
    'Me pidió un adelanto por una plataforma no segura y luego me bloqueó.',
];

for ($i = 0; $i < 3; $i++) {
    // Create report
    Report::create([
        'reporter_id' => $regularUser->id,
        'reported_user_id' => $escortUser->id,
        'reason' => $reasons[$i],
        'description' => $descriptions[$i],
        'status' => 'pending',
    ]);
}

echo "3 reportes falsos con imágenes de evidencia creados correctamente." . PHP_EOL;

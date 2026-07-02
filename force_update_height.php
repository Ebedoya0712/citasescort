<?php

use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Updating height for escort ID 51...\n";

// Direct SQL update to ensure it works
DB::table('escorts')
    ->where('id', 51)
    ->update(['height' => '1.75']);

echo "✓ Height updated to 1.75 m\n";

// Verify
$escort = DB::table('escorts')->where('id', 51)->first();
echo "Current height in DB: " . $escort->height . "\n";

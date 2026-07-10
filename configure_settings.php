<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Setting;

$updates = [
    'site_name' => 'Citas Escort',
    'footer_text' => '© 2026 Citas Escort. Todos los derechos reservados.',
    'seo_title' => 'Citas Escort - Escorts VIP en Perú',
    'seo_description' => 'Encuentra las mejores escorts verificadas en Perú. Perfiles exclusivos, verificados y de alta calidad.',
    'facebook_url' => '',
    'instagram_url' => '',
    'enable_payments' => '0',
    'mercadopago_access_token' => '',
    'mercadopago_public_key' => '',
    'paypal_client_id' => '',
    'paypal_secret' => '',
];

foreach ($updates as $key => $value) {
    $setting = Setting::where('key', $key)->first();
    if ($setting) {
        $setting->value = $value;
        $setting->save();
        echo "$key => UPDATED" . PHP_EOL;
    } else {
        echo "$key => NOT FOUND" . PHP_EOL;
    }
}

echo PHP_EOL . "=== Configuración actualizada correctamente ===" . PHP_EOL;

// Show current values
echo PHP_EOL . "Valores actuales:" . PHP_EOL;
$all = Setting::all();
foreach ($all as $s) {
    echo "  [{$s->group}] {$s->label}: " . ($s->value ?: '(vacío)') . PHP_EOL;
}

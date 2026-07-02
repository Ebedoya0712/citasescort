<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Plan;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Str;

// Create 3 Plans
Plan::truncate();

$plans = [
    [
        'name' => 'Básico',
        'price' => 500.00,
        'duration_days' => 30,
        'description' => 'Plan básico de 1 mes con visibilidad estándar en los listados.',
    ],
    [
        'name' => 'Premium',
        'price' => 1200.00,
        'duration_days' => 90,
        'description' => 'Plan de 3 meses con mejor posicionamiento y badge destacado.',
    ],
    [
        'name' => 'VIP',
        'price' => 2000.00,
        'duration_days' => 180,
        'description' => 'Plan de 6 meses con la máxima visibilidad en toda la plataforma y soporte prioritario.',
    ],
];

foreach ($plans as $plan) {
    Plan::create($plan);
}
echo "3 Planes (suscripciones) creados correctamente." . PHP_EOL;


// Create Fake Payments
Payment::truncate();

$users = User::whereIn('role', ['escort', 'casa de masajes', 'user'])->get();

if ($users->count() === 0) {
    echo "No hay usuarios en la base de datos para crear pagos." . PHP_EOL;
    exit;
}

$statuses = ['completed', 'pending', 'failed'];
$gateways = ['mercadopago', 'paypal'];

for ($i = 0; $i < 15; $i++) {
    $randomUser = $users->random();
    $randomPlan = collect($plans)->random();
    $status = $statuses[array_rand($statuses)];
    $gateway = $gateways[array_rand($gateways)];
    
    Payment::create([
        'user_id' => $randomUser->id,
        'amount' => $randomPlan['price'],
        'status' => $status,
        'gateway' => $gateway,
        'transaction_id' => ($status === 'completed' || $status === 'pending') ? strtoupper(Str::random(12)) : null,
        'created_at' => now()->subDays(rand(0, 30))->subHours(rand(0, 23)),
        'updated_at' => now()->subDays(rand(0, 30)),
    ]);
}

echo "15 Pagos falsos generados correctamente." . PHP_EOL;

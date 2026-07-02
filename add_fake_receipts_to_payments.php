<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Payment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

Storage::disk('public')->makeDirectory('payments/receipts');

$imageUrls = [
    'https://picsum.photos/300/400?random=11',
    'https://picsum.photos/300/400?random=12',
    'https://picsum.photos/300/400?random=13',
];

$payments = Payment::all();

foreach ($payments as $index => $payment) {
    if ($index < 5) { // Only add to first 5 for speed and demonstration
        $imageContent = file_get_contents($imageUrls[$index % 3]);
        $filename = 'payments/receipts/' . Str::random(10) . '.jpg';
        Storage::disk('public')->put($filename, $imageContent);
        
        $payment->update(['receipt_image' => $filename]);
        echo "Receipt added to payment ID: {$payment->id}" . PHP_EOL;
    }
}

echo "Done." . PHP_EOL;

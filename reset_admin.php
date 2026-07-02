<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = \App\Models\User::where('email', 'admin@uruguapas.com')
    ->orWhere('email', 'admin@citasescort.com')
    ->first() ?: new \App\Models\User();

$user->email = 'admin@citasescort.com';
$user->name = 'Admin User';
$user->password = bcrypt('password');
$user->role = 'admin';
$user->save();

echo "Admin account ensured with email admin@citasescort.com and password 'password'.\n";

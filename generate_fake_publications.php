<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Escort;
use App\Models\Publication;
use Faker\Factory as Faker;

$faker = Faker::create('es_ES');
$escorts = Escort::inRandomOrder()->limit(15)->get();

if ($escorts->count() === 0) {
    echo "No hay escorts disponibles.";
    exit;
}

foreach ($escorts as $escort) {
    Publication::create([
        'escort_id' => $escort->id,
        'title' => 'Hola soy ' . $escort->name . ', ' . $faker->catchPhrase,
        'description' => $faker->realText(300),
        'photos' => [
            'https://picsum.photos/400/600?random=' . rand(1, 1000),
            'https://picsum.photos/400/600?random=' . rand(1, 1000)
        ],
        'price' => $faker->randomElement([50000, 80000, 100000, 150000]),
        'currency' => 'CLP',
        'city' => $faker->randomElement(['Lima', 'Miraflores', 'San Isidro', 'Barranco', 'Arequipa', 'Trujillo', 'Chiclayo', 'Cusco', 'Piura', 'Iquitos']),
        'oral_sex' => $faker->randomElement(['Con condón', 'Sin condón', 'No realiza']),
        'fantasies' => $faker->randomElements(['Disfraces', 'Lluvia dorada', 'Tríos', 'BDSM ligero'], rand(1, 3)),
        'virtual_services' => $faker->randomElements(['Videollamada', 'Venta de fotos', 'Sexting'], rand(1, 2)),
        'age' => $faker->numberBetween(18, 45),
        'gender' => 'Mujer',
        'height' => $faker->randomElement(['1.60', '1.65', '1.70', '1.75']),
        'hair_color' => $faker->randomElement(['Rubia', 'Morena', 'Pelirroja', 'Castaña']),
        'phone' => $faker->phoneNumber,
        'whatsapp' => $faker->phoneNumber,
        'instagram' => '@' . $faker->userName,
        'twitter' => '@' . $faker->userName,
        'onlyfans' => 'onlyfans.com/' . $faker->userName,
        'is_active' => true,
        'attends_in' => $faker->randomElements(['Motel', 'Hotel', 'Domicilio propio'], rand(1, 3)),
        'attends_to' => $faker->randomElements(['Hombres', 'Mujeres', 'Parejas'], rand(1, 3)),
        'schedule' => 'Lunes a Domingo de 10:00 a 22:00',
        'services' => $faker->randomElements(['Masajes', 'Trato de novios', 'Beso en la boca', 'Anal'], rand(2, 4)),
    ]);
}

echo "15 perfiles publicos creados exitosamente.\n";

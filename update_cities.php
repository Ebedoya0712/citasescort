<?php

$cities = ['Lima', 'Arequipa', 'Trujillo', 'Chiclayo', 'Cusco', 'Piura', 'Iquitos', 'Tacna', 'Chimbote', 'Huancayo'];
$neighborhoods = ['Miraflores', 'San Isidro', 'Barranco', 'San Borja', 'Santiago de Surco', 'La Molina', 'San Miguel', 'Lince', 'Jesús María', 'Magdalena del Mar'];

foreach(\App\Models\Escort::all() as $e) { 
    $e->city = $cities[array_rand($cities)]; 
    $e->district = $neighborhoods[array_rand($neighborhoods)];
    $e->save(); 
}

foreach(\App\Models\Publication::all() as $p) { 
    $p->city = $p->escort->city; 
    $p->district = $p->escort->district;
    $p->save(); 
}
echo 'Ciudades actualizadas.';

<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\Escort;
use Illuminate\Console\Command;

class SeedCities extends Command
{
    protected $signature = 'app:seed-cities';
    protected $description = 'Replace all cities and distribute escorts';

    public function handle()
    {
        $cities = [
            'Montevideo', 'Maldonado', 'Punta Del Este', 'Tres Cruces', 'Canelones',
            'Pocitos', 'Ciudad de la Costa', 'Centro', 'Cordon', 'La Comercial',
            'Aguada', 'Palacio Legislativo', 'Paso Molino', 'Paysandu', 'Pando',
            'Union', 'Prado', 'Ciudad Vieja', 'Piedras Blancas', 'Punta Carretas',
            'San Jose', 'La Blanqueada', 'Las Piedras', 'Soriano', 'Colonia',
            'La Teja', 'Parque Batlle', 'Parque Del Plata', 'Reducto', 'Atlantida',
            'Colon', 'Costa de Oro', 'Flor de Maronas', 'Malvin', 'Nuevo Centro',
            'Salto', 'Cerro', 'Ciudad Del Plata', 'Colonia del Sacramento', 'Durazno',
            'Buceo', 'Parque Rodo', 'Punta de Rieles', 'Sayago', 'Toledo',
            'Treinta y Tres', 'Brazo Oriental', 'Cerrito', 'Hipodromo', 'Mercedes',
            'Rocha', 'Villa Espanola', 'Artigas', 'Belvedere', 'Carrasco',
            'Casavalle', 'Cerro Largo', 'Chuy', 'Jacinto Vera', 'Lavalleja',
            'Melo', 'Palermo', 'Piriapolis', 'Carmelo', 'Carrasco Norte',
            'Colonia Nicolich', 'Ituzaingo', 'La Paz', 'Marindia', 'Nuevo Paris',
            'Paso de la Arena', 'Rio Negro', 'Rivera', 'Solymar', 'Tacuarembo', 'Virtual',
        ];

        // Insert cities
        foreach ($cities as $name) {
            City::firstOrCreate(['name' => $name], ['department_id' => 1]);
        }
        $this->info("Total cities: " . City::count());

        // Distribute escorts so every city has at least one
        $popular = ['Montevideo', 'Punta Del Este', 'Maldonado', 'Tres Cruces', 'Canelones', 'Pocitos', 'Ciudad de la Costa', 'Centro', 'Cordon'];
        $escorts = Escort::all()->shuffle();
        $totalEscorts = $escorts->count();
        $allCities = $cities;
        $cityCount = count($allCities);

        // First pass: assign one escort per city (cycling escorts if fewer than cities)
        foreach ($allCities as $i => $cityName) {
            $escort = $escorts[$i % $totalEscorts];
            $escort->update(['city' => $cityName]);
        }

        // Second pass: remaining escorts (those beyond cityCount) go to popular cities
        if ($totalEscorts > $cityCount) {
            for ($i = $cityCount; $i < $totalEscorts; $i++) {
                $escorts[$i]->update(['city' => $popular[array_rand($popular)]]);
            }
        }

        $this->info("Distributed {$totalEscorts} escorts across {$cityCount} cities.");
    }
}

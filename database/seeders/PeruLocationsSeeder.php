<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;

class PeruLocationsSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            'Amazonas',
            'Áncash',
            'Apurímac',
            'Arequipa',
            'Ayacucho',
            'Cajamarca',
            'Callao',
            'Cusco',
            'Huancavelica',
            'Huánuco',
            'Ica',
            'Junín',
            'La Libertad',
            'Lambayeque',
            'Lima',
            'Loreto',
            'Madre de Dios',
            'Moquegua',
            'Pasco',
            'Piura',
            'Puno',
            'San Martín',
            'Tacna',
            'Tumbes',
            'Ucayali'
        ];

        // Clean up old cities/districts that are not departments
        City::whereNotIn('name', $departments)->delete();

        foreach ($departments as $departmentName) {
            City::firstOrCreate([
                'name' => $departmentName
            ]);
        }
    }
}

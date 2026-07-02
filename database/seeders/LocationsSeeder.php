<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\City;

class LocationsSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            'Lima' => [
                'Lima', 'Miraflores', 'San Isidro', 'Barranco', 'Santiago de Surco', 'La Molina', 'San Borja', 'Chorrillos', 'San Miguel', 'Lince', 'Jesús María', 'Magdalena del Mar', 'Pueblo Libre', 'Surquillo'
            ],
            'Arequipa' => [
                'Arequipa', 'Yanahuara', 'Cayma', 'Bustamante y Rivero', 'Cerro Colorado', 'Mollebaya', 'Sabandía'
            ],
            'La Libertad' => [
                'Trujillo', 'Huanchaco', 'Víctor Larco Herrera', 'Moche', 'El Porvenir'
            ],
            'Piura' => [
                'Piura', 'Castilla', 'Catacaos', 'Sullana', 'Talara', 'Máncora'
            ],
            'Lambayeque' => [
                'Chiclayo', 'Lambayeque', 'Pimentel', 'La Victoria'
            ],
            'Cusco' => [
                'Cusco', 'Wanchaq', 'San Sebastián', 'San Jerónimo', 'Urubamba'
            ],
            'Ica' => [
                'Ica', 'Chincha Alta', 'Pisco', 'Nazca', 'Paracas'
            ],
            'Junín' => [
                'Huancayo', 'Tarma', 'Jauja', 'Chanchamayo'
            ],
            'Loreto' => [
                'Iquitos', 'Yurimaguas'
            ],
            'Tacna' => [
                'Tacna', 'Pocollay'
            ],
            'San Martín' => [
                'Tarapoto', 'Moyobamba'
            ],
            'Ancash' => [
                'Chimbote', 'Huaraz', 'Nuevo Chimbote'
            ]
        ];

        foreach ($locations as $departmentName => $cities) {
            $department = Department::firstOrCreate(['name' => $departmentName]);

            foreach ($cities as $cityName) {
                City::firstOrCreate([
                    'name' => $cityName,
                    'department_id' => $department->id
                ]);
            }
        }
    }
}

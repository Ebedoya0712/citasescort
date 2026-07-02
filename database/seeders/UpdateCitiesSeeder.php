<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Escort;
use App\Models\Publication;

class UpdateCitiesSeeder extends Seeder
{
    public function run(): void
    {
        $cities = ['Lima', 'Arequipa', 'Trujillo', 'Chiclayo', 'Cusco', 'Piura', 'Iquitos', 'Tacna', 'Chimbote', 'Huancayo'];
        $districts = ['Miraflores', 'San Isidro', 'Barranco', 'San Borja', 'Santiago de Surco', 'La Molina', 'San Miguel', 'Lince', 'Jesús María', 'Magdalena del Mar'];

        foreach(Escort::all() as $e) { 
            $e->city = $cities[array_rand($cities)]; 
            $e->save(); 
        }

        foreach(Publication::all() as $p) { 
            if($p->escort) {
                $p->city = $p->escort->city; 
                $p->save(); 
            }
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\City;

class PeruLocationsSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            'Amazonas' => [
                'Chachapoyas', 'Bagua', 'Bagua Grande', 'Condorcanqui', 'Luya', 'Rodríguez de Mendoza'
            ],
            'Áncash' => [
                'Huaraz', 'Chimbote', 'Nuevo Chimbote', 'Caraz', 'Casma', 'Huarmey', 'Yungay', 'Carhuaz'
            ],
            'Apurímac' => [
                'Abancay', 'Andahuaylas', 'Chincheros', 'Grau', 'Cotabambas'
            ],
            'Arequipa' => [
                'Arequipa', 'Yanahuara', 'Cayma', 'Bustamante y Rivero', 'Cerro Colorado', 'Mollebaya', 'Sabandía', 'Camaná', 'Mollendo', 'Mejía', 'Socabaya', 'Miraflores', 'Mariano Melgar', 'Paucarpata', 'Hunter', 'Sachaca', 'Tiabaya', 'Uchumayo'
            ],
            'Ayacucho' => [
                'Ayacucho', 'Huamanga', 'Huanta', 'San Juan Bautista', 'Jesús Nazareno', 'Carmen Alto'
            ],
            'Cajamarca' => [
                'Cajamarca', 'Jaén', 'Chota', 'Cutervo', 'Celendín', 'Bambamarca', 'San Ignacio'
            ],
            'Callao' => [
                'Callao', 'Bellavista', 'Carmen de la Legua Reynoso', 'La Perla', 'La Punta', 'Mi Perú', 'Ventanilla'
            ],
            'Cusco' => [
                'Cusco', 'Wanchaq', 'San Sebastián', 'San Jerónimo', 'Urubamba', 'Santiago', 'Ollantaytambo', 'Pisac', 'Calca', 'Sicuani', 'Quillabamba'
            ],
            'Huancavelica' => [
                'Huancavelica', 'Acobamba', 'Angaraes', 'Lircay', 'Pampas', 'Tayacaja'
            ],
            'Huánuco' => [
                'Huánuco', 'Tingo María', 'Amarilis', 'Pillco Marca', 'Leoncio Prado'
            ],
            'Ica' => [
                'Ica', 'Chincha Alta', 'Pisco', 'Nazca', 'Paracas', 'Los Aquijes', 'Parcona', 'Subtanjalla', 'San Clemente'
            ],
            'Junín' => [
                'Huancayo', 'Tarma', 'Jauja', 'Chanchamayo', 'La Merced', 'San Ramón', 'Satipo', 'El Tambo', 'Chilca'
            ],
            'La Libertad' => [
                'Trujillo', 'Huanchaco', 'Víctor Larco Herrera', 'Moche', 'El Porvenir', 'La Esperanza', 'Florencia de Mora', 'Laredo', 'Salaverry', 'Santiago de Cao', 'Chepén', 'Pacasmayo'
            ],
            'Lambayeque' => [
                'Chiclayo', 'Lambayeque', 'Pimentel', 'La Victoria', 'José Leonardo Ortiz', 'Monsefú', 'Eten', 'Ferreñafe', 'Olmos', 'Motupe'
            ],
            'Lima' => [
                'Ancón', 'Ate', 'Barranco', 'Breña', 'Carabayllo', 'Chaclacayo', 'Chorrillos', 'Cieneguilla', 'Comas', 'El Agustino', 'Independencia', 'Jesús María', 'La Molina', 'La Victoria', 'Lima', 'Lince', 'Los Olivos', 'Lurigancho', 'Lurín', 'Magdalena del Mar', 'Miraflores', 'Pachacámac', 'Pucusana', 'Pueblo Libre', 'Puente Piedra', 'Punta Hermosa', 'Punta Negra', 'Rímac', 'San Bartolo', 'San Borja', 'San Isidro', 'San Juan de Lurigancho', 'San Juan de Miraflores', 'San Luis', 'San Martín de Porres', 'San Miguel', 'Santa Anita', 'Santa María del Mar', 'Santa Rosa', 'Santiago de Surco', 'Surquillo', 'Villa El Salvador', 'Villa María del Triunfo'
            ],
            'Loreto' => [
                'Iquitos', 'Yurimaguas', 'Nauta', 'Requena', 'Contamana', 'San Juan Bautista', 'Punchana', 'Belén'
            ],
            'Madre de Dios' => [
                'Puerto Maldonado', 'Tambopata', 'Manu', 'Tahuamanu', 'Iberia', 'Iñapari'
            ],
            'Moquegua' => [
                'Moquegua', 'Ilo', 'Mariscal Nieto', 'General Sánchez Cerro', 'Samegua', 'Torata'
            ],
            'Pasco' => [
                'Cerro de Pasco', 'Oxapampa', 'Daniel Alcides Carrión', 'Villa Rica', 'Yanahuanca'
            ],
            'Piura' => [
                'Piura', 'Castilla', 'Catacaos', 'Sullana', 'Talara', 'Máncora', 'Paita', 'Sechura', 'Chulucanas', 'Tambogrande', 'Morropón', 'Ayabaca', 'Huancabamba', 'Los Órganos', 'Colán'
            ],
            'Puno' => [
                'Puno', 'Juliaca', 'Ayaviri', 'Ilave', 'Azángaro', 'Lampa', 'Macusani', 'Desaguadero'
            ],
            'San Martín' => [
                'Tarapoto', 'Moyobamba', 'Rioja', 'Juanjuí', 'Lamas', 'Tocache', 'Bellavista', 'Saposoa', 'Morales', 'La Banda de Shilcayo'
            ],
            'Tacna' => [
                'Tacna', 'Pocollay', 'Alto de la Alianza', 'Ciudad Nueva', 'Gregorio Albarracín', 'Calana', 'Sama', 'Candarave'
            ],
            'Tumbes' => [
                'Tumbes', 'Zarumilla', 'Contralmirante Villar', 'Zorritos', 'Aguas Verdes', 'Corrales', 'San Jacinto'
            ],
            'Ucayali' => [
                'Pucallpa', 'Callería', 'Yarinacocha', 'Manantay', 'Campo Verde', 'Aguaytía', 'Atalaya'
            ],
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

        // Clean up old department name "Ancash" (without accent) if it exists
        $oldAncash = Department::where('name', 'Ancash')->first();
        if ($oldAncash) {
            $newAncash = Department::where('name', 'Áncash')->first();
            if ($newAncash && $oldAncash->id !== $newAncash->id) {
                // Move cities from old to new
                City::where('department_id', $oldAncash->id)->update(['department_id' => $newAncash->id]);
                $oldAncash->delete();
            }
        }
    }
}

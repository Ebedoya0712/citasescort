<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Establishment;

class EstablishmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $descriptionMotel = "En este lugar de ensueño hay para elegir entre múltiples habitaciones divididas en varias categorías, equipadas cada una de ellas con TV LED y cable, señales para adultos, señales privadas, audio centralizado, aire acondicionado y calefacción por losa radiante.\n\nTambién cuentan con servicios adicionales, desde una amplia selección gastronómica con platos preparados, snacks y bebidas servidos las 24 horas en tu habitación, Sex Shop o frigobar completo. El turno nocturno incluye desayuno en tu habitación de 07:00 AM a 10:00 AM.\n\nPara resguardar la privacidad del cliente y garantizar la discreción, todas las comunicaciones con el personal se realizan por medios electrónicos.";
        $descriptionSpa = "Nuestro spa y centro de masajes está diseñado para brindarte una experiencia de relajación total. Contamos con terapeutas profesionales y discretos que te ayudarán a liberar tensiones en un ambiente seguro y privado.\n\nDisfruta de nuestros servicios premium que incluyen aromaterapia, jacuzzi privado con hidromasaje, y una variedad de técnicas diseñadas a medida.\n\nTu tranquilidad es nuestra prioridad. Te esperamos.";
        $descriptionWhiskeria = "Ven y disfruta de la mejor vida nocturna en nuestro exclusivo local. Contamos con la mejor coctelería, un ambiente seguro, excelente música y la compañía ideal.\n\nContamos con zonas VIP, promociones en bebidas toda la noche, pista de baile y la privacidad que buscas. Celebra tus eventos, despedidas o simplemente relájate después del trabajo.\n\nEl mejor ambiente de la ciudad está aquí.";

        // Whiskerías
        Establishment::updateOrCreate(['name' => 'Club Le Baron'], [
            'type' => 'whiskeria',
            'address' => 'Av. Arequipa 1530, Lince, Lima',
            'latitude' => -12.0805,
            'longitude' => -77.0345,
            'phone' => '990000001',
            'whatsapp' => '+51990000001',
            'cover_image' => 'https://images.unsplash.com/photo-1572116469696-31de0f17cc34?q=80&w=2000&auto=format&fit=crop', // Club/bar
            'description' => $descriptionWhiskeria,
            'rating' => 4.5,
            'is_active' => true,
            'status' => 'approved'
        ]);

        Establishment::updateOrCreate(['name' => 'Priveé Lima'], [
            'type' => 'whiskeria',
            'address' => 'Av. Conquistadores 450, San Isidro, Lima',
            'latitude' => -12.0990,
            'longitude' => -77.0360,
            'phone' => '990000002',
            'cover_image' => 'https://images.unsplash.com/photo-1566737236500-c8ac43014a67?q=80&w=2000&auto=format&fit=crop', // Nightclub
            'description' => $descriptionWhiskeria,
            'rating' => 4.8,
            'is_active' => true,
            'status' => 'approved'
        ]);

        Establishment::updateOrCreate(['name' => 'La Cabaña Night Club'], [
            'type' => 'whiskeria',
            'address' => 'Av. Petit Thouars 2200, Lince, Lima',
            'latitude' => -12.0860,
            'longitude' => -77.0335,
            'phone' => '990000003',
            'cover_image' => 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=2000&auto=format&fit=crop', // Lounge
            'description' => $descriptionWhiskeria,
            'rating' => 4.2,
            'is_active' => true,
            'status' => 'approved'
        ]);

        // Casas de Masajes
        Establishment::updateOrCreate(['name' => 'Spa Relax Lima'], [
            'type' => 'massage',
            'address' => 'Calle Schell 340, Miraflores, Lima',
            'latitude' => -12.1215,
            'longitude' => -77.0285,
            'phone' => '991000001',
            'whatsapp' => '+51991000001',
            'website' => 'https://relaxcenterlima.example.com',
            'cover_image' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?q=80&w=2000&auto=format&fit=crop', // Massage bed
            'description' => $descriptionSpa,
            'rating' => 4.9,
            'is_active' => true,
            'status' => 'approved'
        ]);

        Establishment::updateOrCreate(['name' => 'Manos Mágicas Spa'], [
            'type' => 'massage',
            'address' => 'Av. Larco 750, Miraflores, Lima',
            'latitude' => -12.1255,
            'longitude' => -77.0300,
            'phone' => '991000002',
            'cover_image' => 'https://images.unsplash.com/photo-1519823551278-64ac92734fb1?q=80&w=2000&auto=format&fit=crop', // Spa
            'description' => $descriptionSpa,
            'rating' => 4.0,
            'is_active' => true,
            'status' => 'approved'
        ]);

        Establishment::updateOrCreate(['name' => 'Spa Urbano San Isidro'], [
            'type' => 'massage',
            'address' => 'Av. Javier Prado Este 1100, San Isidro, Lima',
            'latitude' => -12.0915,
            'longitude' => -77.0245,
            'phone' => '991000003',
            'cover_image' => 'https://images.unsplash.com/photo-1515377905703-c4788e51af15?q=80&w=2000&auto=format&fit=crop', // Spa alternative
            'description' => $descriptionSpa,
            'rating' => 4.7,
            'is_active' => true,
            'status' => 'approved'
        ]);

        // Moteles
        Establishment::updateOrCreate(['name' => 'Hotel Las Palmeras'], [
            'type' => 'motel',
            'address' => 'Av. Pedro de Osma 230, Barranco, Lima',
            'latitude' => -12.1510,
            'longitude' => -77.0220,
            'phone' => '992000001',
            'whatsapp' => '+51992000001',
            'website' => 'https://laspalmeraslima.example.com',
            'cover_image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?q=80&w=2000&auto=format&fit=crop', // Hotel room
            'description' => $descriptionMotel,
            'rating' => 4.6,
            'is_active' => true,
            'status' => 'approved'
        ]);

        Establishment::updateOrCreate(['name' => 'Motel Séptimo Cielo'], [
            'type' => 'motel',
            'address' => 'Av. La Marina 3200, San Miguel, Lima',
            'latitude' => -12.0780,
            'longitude' => -77.0860,
            'phone' => '992000002',
            'cover_image' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?q=80&w=2000&auto=format&fit=crop', // Luxury bedroom alternative
            'description' => $descriptionMotel,
            'rating' => 4.8,
            'is_active' => true,
            'status' => 'approved'
        ]);
        
        Establishment::updateOrCreate(['name' => 'Hospedaje El Eden'], [
            'type' => 'motel',
            'address' => 'Av. Javier Prado Oeste 2200, Magdalena del Mar, Lima',
            'latitude' => -12.0930,
            'longitude' => -77.0580,
            'phone' => '992000003',
            'cover_image' => 'https://images.unsplash.com/photo-1590490359683-658d3d23f972?q=80&w=2000&auto=format&fit=crop', // Hotel bed
            'description' => $descriptionMotel,
            'rating' => 4.1,
            'is_active' => true,
            'status' => 'approved'
        ]);

        // Additional Whiskerías
        Establishment::updateOrCreate(['name' => 'The Golden Club'], [
            'type' => 'whiskeria',
            'address' => 'Av. Tomás Valle 450, Los Olivos, Lima',
            'latitude' => -12.0085,
            'longitude' => -77.0620,
            'phone' => '990000010',
            'cover_image' => 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=2000&auto=format&fit=crop',
            'description' => $descriptionWhiskeria,
            'rating' => 4.6,
            'is_active' => true,
            'status' => 'approved'
        ]);

        Establishment::updateOrCreate(['name' => 'Bar Moonlight'], [
            'type' => 'whiskeria',
            'address' => 'Av. Primavera 1280, Santiago de Surco, Lima',
            'latitude' => -12.1120,
            'longitude' => -76.9805,
            'phone' => '990000011',
            'cover_image' => 'https://images.unsplash.com/photo-1572116469696-31de0f17cc34?q=80&w=2000&auto=format&fit=crop',
            'description' => $descriptionWhiskeria,
            'rating' => 4.4,
            'is_active' => true,
            'status' => 'approved'
        ]);

        Establishment::updateOrCreate(['name' => 'La Nené Night Club'], [
            'type' => 'whiskeria',
            'address' => 'Av. Nicolás de Piérola 750, Centro de Lima, Lima',
            'latitude' => -12.0495,
            'longitude' => -77.0370,
            'phone' => '990000012',
            'cover_image' => 'https://images.unsplash.com/photo-1566737236500-c8ac43014a67?q=80&w=2000&auto=format&fit=crop',
            'description' => $descriptionWhiskeria,
            'rating' => 4.3,
            'is_active' => true,
            'status' => 'approved'
        ]);

        // Additional Spas
        Establishment::updateOrCreate(['name' => 'Aqua Spa & Wellness'], [
            'type' => 'massage',
            'address' => 'Av. Javier Prado Este 2500, San Borja, Lima',
            'latitude' => -12.0885,
            'longitude' => -76.9940,
            'phone' => '991000010',
            'cover_image' => 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?q=80&w=2000&auto=format&fit=crop',
            'description' => $descriptionSpa,
            'rating' => 4.8,
            'is_active' => true,
            'status' => 'approved'
        ]);

        Establishment::updateOrCreate(['name' => 'Orquídeas Spa'], [
            'type' => 'massage',
            'address' => 'Calle Las Orquídeas 520, San Isidro, Lima',
            'latitude' => -12.0945,
            'longitude' => -77.0290,
            'phone' => '991000011',
            'cover_image' => 'https://images.unsplash.com/photo-1519823551278-64ac92734fb1?q=80&w=2000&auto=format&fit=crop',
            'description' => $descriptionSpa,
            'rating' => 4.6,
            'is_active' => true,
            'status' => 'approved'
        ]);

        Establishment::updateOrCreate(['name' => 'Lotus Relax Spa'], [
            'type' => 'massage',
            'address' => 'Av. Manuel Cipriano Dulanto 1100, Pueblo Libre, Lima',
            'latitude' => -12.0775,
            'longitude' => -77.0690,
            'phone' => '991000012',
            'cover_image' => 'https://images.unsplash.com/photo-1515377905703-c4788e51af15?q=80&w=2000&auto=format&fit=crop',
            'description' => $descriptionSpa,
            'rating' => 4.5,
            'is_active' => true,
            'status' => 'approved'
        ]);

        // Additional Moteles
        Establishment::updateOrCreate(['name' => 'Palace Hotel'], [
            'type' => 'motel',
            'address' => 'Av. Benavides 3800, Santiago de Surco, Lima',
            'latitude' => -12.1290,
            'longitude' => -76.9920,
            'phone' => '992000010',
            'cover_image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?q=80&w=2000&auto=format&fit=crop',
            'description' => $descriptionMotel,
            'rating' => 4.7,
            'is_active' => true,
            'status' => 'approved'
        ]);

        Establishment::updateOrCreate(['name' => 'Hospedaje Las Rocas'], [
            'type' => 'motel',
            'address' => 'Av. Huaylas 820, Chorrillos, Lima',
            'latitude' => -12.1720,
            'longitude' => -77.0180,
            'phone' => '992000011',
            'cover_image' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?q=80&w=2000&auto=format&fit=crop',
            'description' => $descriptionMotel,
            'rating' => 4.3,
            'is_active' => true,
            'status' => 'approved'
        ]);

        Establishment::updateOrCreate(['name' => 'Hotel Suite Caricia'], [
            'type' => 'motel',
            'address' => 'Av. Canadá 1420, La Victoria, Lima',
            'latitude' => -12.0815,
            'longitude' => -77.0105,
            'phone' => '992000012',
            'cover_image' => 'https://images.unsplash.com/photo-1590490359683-658d3d23f972?q=80&w=2000&auto=format&fit=crop',
            'description' => $descriptionMotel,
            'rating' => 4.5,
            'is_active' => true,
            'status' => 'approved'
        ]);
    }
}

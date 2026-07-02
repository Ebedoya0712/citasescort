<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Escort>
 */
class EscortFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = fake()->randomElement(['female', 'male', 'trans']);
        
        return [
            'user_id' => User::factory(),
            'name' => fake()->firstName($gender === 'male' ? 'male' : 'female'),
            'description' => fake()->paragraph(),
            'age' => fake()->numberBetween(18, 40),
            'gender' => $gender,
            'city' => fake()->randomElement(['Lima', 'Miraflores', 'San Isidro', 'Barranco', 'Arequipa', 'Trujillo', 'Chiclayo', 'Cusco', 'Piura', 'Iquitos']),
            'price' => fake()->numberBetween(100, 500) * 10,
            'is_active' => true,
            'verified' => $verified = fake()->boolean(60),
            'verification_status' => $verified ? 'approved' : 'unverified',
            'level' => fake()->randomElement(['general', 'plata', 'diamante']),
            'photos' => array_map(function() {
                return 'https://ui-avatars.com/api/?name=' . fake()->firstName('female') . '&background=random&size=512';
            }, range(1, 9)), 
            'verification_photos' => [],
            'phone' => fake()->phoneNumber(),
            'whatsapp' => fake()->phoneNumber(),
            'height' => fake()->numberBetween(150, 180),
            'hair_color' => fake()->randomElement(['Rubia', 'Morocha', 'Pelirroja', 'Castaña']),
            'cost_30m' => fake()->numberBetween(50, 250) * 10,
            'services' => fake()->randomElements(['Beso Negro', 'Besos', 'Cambio de roles', 'Dama de Compañía', 'Dominación', 'Eventos', 'Juguetes Eróticos', 'Masajes', 'Sexo Oral', 'Con Preservativo', 'Acabar en Cuerpo', 'Aparatos - Juguetes', 'Disfraces', 'Servicios Virtuales'], 5),
            'attends_to' => fake()->randomElements(['Hombres', 'Mujeres', 'Parejas'], 2),
            'attends_in' => fake()->randomElements(['Lugar propio', 'Hoteles', 'Domicilio', 'Virtual'], 2),
            'video' => null,
        ];
    }
}

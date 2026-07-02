<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CasaDeMasajesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            User::firstOrCreate(
                ['email' => "casamasajes$i@citasescort.com"],
                [
                    'name' => "Casa de Masajes $i",
                    'password' => bcrypt('password'),
                    'role' => 'casa de masajes',
                ]
            );
        }
    }
}


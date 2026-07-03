<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        // Remove old plans
        Plan::query()->delete();

        Plan::create([
            'name' => 'Plata',
            'price' => 20.00,
            'duration_days' => 30,
            'description' => 'Plan Plata de 1 mes con mejor posicionamiento y badge plateado destacado.',
        ]);

        Plan::create([
            'name' => 'Diamante',
            'price' => 50.00,
            'duration_days' => 90,
            'description' => 'Plan Diamante de 3 meses con el mejor posicionamiento y badge de diamante destacado.',
        ]);
    }
}

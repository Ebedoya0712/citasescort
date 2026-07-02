<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Publication;
use App\Models\Escort;

class FixCitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Publication::all() as $p) {
            if ($p->escort) {
                $p->city = $p->escort->city;
                $p->save();
            }
        }
    }
}

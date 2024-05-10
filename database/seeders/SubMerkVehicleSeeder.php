<?php

namespace Database\Seeders;

use App\Models\SubMerkVehicle;
use Illuminate\Database\Seeder;

class SubMerkVehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubMerkVehicle::factory()
            ->count(5)
            ->create();
    }
}

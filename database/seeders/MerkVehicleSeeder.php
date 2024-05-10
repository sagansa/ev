<?php

namespace Database\Seeders;

use App\Models\MerkVehicle;
use Illuminate\Database\Seeder;

class MerkVehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MerkVehicle::factory()
            ->count(5)
            ->create();
    }
}

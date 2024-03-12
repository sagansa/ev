<?php

namespace Database\Seeders;

use App\Models\FuelOilCost;
use Illuminate\Database\Seeder;

class FuelOilCostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FuelOilCost::factory()
            ->count(5)
            ->create();
    }
}

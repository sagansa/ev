<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ElectricCurrent;

class ElectricCurrentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ElectricCurrent::factory()
            ->count(5)
            ->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\ChargerType;
use Illuminate\Database\Seeder;

class ChargerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ChargerType::factory()
            ->count(5)
            ->create();
    }
}

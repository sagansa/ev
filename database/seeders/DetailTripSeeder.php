<?php

namespace Database\Seeders;

use App\Models\DetailTrip;
use Illuminate\Database\Seeder;

class DetailTripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DetailTrip::factory()
            ->count(5)
            ->create();
    }
}

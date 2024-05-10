<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);

        $this->call(ChargeSeeder::class);
        $this->call(ChargerSeeder::class);
        $this->call(ChargerLocationSeeder::class);
        $this->call(ChargerTypeSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(DetailTripSeeder::class);
        $this->call(ElectricCurrentSeeder::class);
        $this->call(FuelOilCostSeeder::class);
        $this->call(MerkVehicleSeeder::class);
        $this->call(ProviderSeeder::class);
        $this->call(ProvinceSeeder::class);
        $this->call(StateOfHealthSeeder::class);
        $this->call(SubMerkVehicleSeeder::class);
        $this->call(TripSeeder::class);
        $this->call(TypeVehicleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(VehicleSeeder::class);
    }
}

<?php

namespace Database\Factories;

use App\Models\Vehicle;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vehicle::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'license_plate' => $this->faker->text(10),
            'ownership' => $this->faker->date(),
            'status' => 'active',
            'type_vehicle_id' => \App\Models\TypeVehicle::factory(),
            'merk_vehicle_id' => \App\Models\MerkVehicle::factory(),
            'sub_merk_vehicle_id' => \App\Models\SubMerkVehicle::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}

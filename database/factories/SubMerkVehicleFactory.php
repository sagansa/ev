<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\SubMerkVehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubMerkVehicleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SubMerkVehicle::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sub_merk' => $this->faker->unique->text(30),
            'battery_capacity' => $this->faker->randomNumber(1),
            'type_vehicle_id' => \App\Models\TypeVehicle::factory(),
            'merk_vehicle_id' => \App\Models\MerkVehicle::factory(),
            'charger_type_id' => \App\Models\ChargerType::factory(),
        ];
    }
}

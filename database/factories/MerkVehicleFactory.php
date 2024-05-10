<?php

namespace Database\Factories;

use App\Models\MerkVehicle;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class MerkVehicleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MerkVehicle::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'merk' => $this->faker->unique->text(20),
            'type_vehicle_id' => \App\Models\TypeVehicle::factory(),
        ];
    }
}

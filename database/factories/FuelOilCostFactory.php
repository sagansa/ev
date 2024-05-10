<?php

namespace Database\Factories;

use App\Models\FuelOilCost;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class FuelOilCostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = FuelOilCost::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'fuel_price' => $this->faker->randomNumber(0),
            'km_start' => $this->faker->randomNumber(0),
            'km_end' => $this->faker->randomNumber(0),
            'vehicle_id' => \App\Models\Vehicle::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}

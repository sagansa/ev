<?php

namespace Database\Factories;

use App\Models\Trip;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TripFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Trip::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'from' => $this->faker->text(255),
            'coordinate_from' => $this->faker->text(255),
            'to' => $this->faker->text(255),
            'coordinate_to' => $this->faker->text(255),
            'vehicle_id' => \App\Models\Vehicle::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}

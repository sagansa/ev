<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\StateOfHealth;
use Illuminate\Database\Eloquent\Factories\Factory;

class StateOfHealthFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StateOfHealth::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'km' => $this->faker->randomNumber(5),
            'percentage' => $this->faker->randomNumber(1),
            'how_to_charge' => $this->faker->text(),
            'status' => 'not verified',
            'user_id' => \App\Models\User::factory(),
            'vehicle_id' => \App\Models\Vehicle::factory(),
        ];
    }
}

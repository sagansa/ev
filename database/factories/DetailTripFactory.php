<?php

namespace Database\Factories;

use App\Models\DetailTrip;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetailTripFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DetailTrip::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'odometer_start' => $this->faker->randomNumber(0),
            'odometer_end' => $this->faker->randomNumber(0),
            'battery_start' => $this->faker->randomNumber(0),
            'battery_end' => $this->faker->randomNumber(0),
            'notes' => $this->faker->text(),
            'trip_id' => \App\Models\Trip::factory(),
            'charger_location_id' => \App\Models\ChargerLocation::factory(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Charge;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChargeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Charge::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'km_now' => $this->faker->randomNumber(0),
            'km_before' => $this->faker->randomNumber(0),
            'battery_start_charging' => $this->faker->randomNumber(0),
            'battery_finish_charging' => $this->faker->randomNumber(0),
            'battery_finish_before' => $this->faker->randomNumber(0),
            'parking' => $this->faker->randomNumber(0),
            'kWh' => $this->faker->randomNumber(0),
            'PPJ' => $this->faker->randomNumber(0),
            'PPN' => $this->faker->randomNumber(0),
            'admin_cost' => $this->faker->randomNumber(0),
            'total_cost' => $this->faker->randomNumber(0),
            'vehicle_id' => \App\Models\Vehicle::factory(),
            'charger_location_id' => \App\Models\ChargerLocation::factory(),
            'charger_id' => \App\Models\Charger::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}

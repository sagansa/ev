<?php

namespace Database\Factories;

use App\Models\Charger;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChargerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Charger::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'power' => $this->faker->text(10),
            'unit' => $this->faker->numberBetween(0, 127),
            'charge_cost' => $this->faker->randomNumber(0),
            'PPJ' => $this->faker->randomNumber(0),
            'admin_cost' => $this->faker->randomNumber(0),
            'PPN' => 'yes',
            'status' => 'not verified',
            'charger_location_id' => \App\Models\ChargerLocation::factory(),
            'charger_type_id' => \App\Models\ChargerType::factory(),
            'user_id' => \App\Models\User::factory(),
            'electric_current_id' => \App\Models\ElectricCurrent::factory(),
        ];
    }
}

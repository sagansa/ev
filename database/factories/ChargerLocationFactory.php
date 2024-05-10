<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ChargerLocation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChargerLocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ChargerLocation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'location_on' => 'public',
            'status' => 'not verified',
            'description' => $this->faker->sentence(15),
            'maps' => $this->faker->text(255),
            'system' => 'free',
            'parking' => 'yes',
            'coordinate' => $this->faker->text(100),
            'provider_id' => \App\Models\Provider::factory(),
            'city_id' => \App\Models\City::factory(),
            'province_id' => \App\Models\Province::factory(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}

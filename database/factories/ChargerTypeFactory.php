<?php

namespace Database\Factories;

use App\Models\ChargerType;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChargerTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ChargerType::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique->text(10),
        ];
    }
}

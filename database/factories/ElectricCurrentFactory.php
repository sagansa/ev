<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ElectricCurrent;
use Illuminate\Database\Eloquent\Factories\Factory;

class ElectricCurrentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ElectricCurrent::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'AC',
        ];
    }
}

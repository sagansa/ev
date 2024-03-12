<?php

namespace Database\Factories;

use App\Models\Provider;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProviderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Provider::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique->text(20),
            'status' => 'not verified',
            'user_id' => \App\Models\User::factory(),
        ];
    }
}

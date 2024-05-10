<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\FuelOilCost;

use App\Models\Vehicle;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FuelOilCostTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_fuel_oil_costs_list(): void
    {
        $fuelOilCosts = FuelOilCost::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.fuel-oil-costs.index'));

        $response->assertOk()->assertSee($fuelOilCosts[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_fuel_oil_cost(): void
    {
        $data = FuelOilCost::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.fuel-oil-costs.store'), $data);

        $this->assertDatabaseHas('fuel_oil_costs', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_fuel_oil_cost(): void
    {
        $fuelOilCost = FuelOilCost::factory()->create();

        $vehicle = Vehicle::factory()->create();
        $user = User::factory()->create();

        $data = [
            'vehicle_id' => $this->faker->uuid(),
            'date' => $this->faker->date(),
            'fuel_price' => $this->faker->randomNumber(0),
            'km_start' => $this->faker->randomNumber(0),
            'km_end' => $this->faker->randomNumber(0),
            'user_id' => $this->faker->uuid(),
            'vehicle_id' => $vehicle->id,
            'user_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.fuel-oil-costs.update', $fuelOilCost),
            $data
        );

        $data['id'] = $fuelOilCost->id;

        $this->assertDatabaseHas('fuel_oil_costs', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_fuel_oil_cost(): void
    {
        $fuelOilCost = FuelOilCost::factory()->create();

        $response = $this->deleteJson(
            route('api.fuel-oil-costs.destroy', $fuelOilCost)
        );

        $this->assertModelMissing($fuelOilCost);

        $response->assertNoContent();
    }
}

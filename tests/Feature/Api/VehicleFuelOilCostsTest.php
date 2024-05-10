<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\FuelOilCost;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VehicleFuelOilCostsTest extends TestCase
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
    public function it_gets_vehicle_fuel_oil_costs(): void
    {
        $vehicle = Vehicle::factory()->create();
        $fuelOilCosts = FuelOilCost::factory()
            ->count(2)
            ->create([
                'vehicle_id' => $vehicle->id,
            ]);

        $response = $this->getJson(
            route('api.vehicles.fuel-oil-costs.index', $vehicle)
        );

        $response->assertOk()->assertSee($fuelOilCosts[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_vehicle_fuel_oil_costs(): void
    {
        $vehicle = Vehicle::factory()->create();
        $data = FuelOilCost::factory()
            ->make([
                'vehicle_id' => $vehicle->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.vehicles.fuel-oil-costs.store', $vehicle),
            $data
        );

        $this->assertDatabaseHas('fuel_oil_costs', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $fuelOilCost = FuelOilCost::latest('id')->first();

        $this->assertEquals($vehicle->id, $fuelOilCost->vehicle_id);
    }
}

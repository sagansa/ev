<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\MerkVehicle;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MerkVehicleVehiclesTest extends TestCase
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
    public function it_gets_merk_vehicle_vehicles(): void
    {
        $merkVehicle = MerkVehicle::factory()->create();
        $vehicles = Vehicle::factory()
            ->count(2)
            ->create([
                'merk_vehicle_id' => $merkVehicle->id,
            ]);

        $response = $this->getJson(
            route('api.merk-vehicles.vehicles.index', $merkVehicle)
        );

        $response->assertOk()->assertSee($vehicles[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_merk_vehicle_vehicles(): void
    {
        $merkVehicle = MerkVehicle::factory()->create();
        $data = Vehicle::factory()
            ->make([
                'merk_vehicle_id' => $merkVehicle->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.merk-vehicles.vehicles.store', $merkVehicle),
            $data
        );

        unset($data['status']);

        $this->assertDatabaseHas('vehicles', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $vehicle = Vehicle::latest('id')->first();

        $this->assertEquals($merkVehicle->id, $vehicle->merk_vehicle_id);
    }
}

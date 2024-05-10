<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\SubMerkVehicle;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubMerkVehicleVehiclesTest extends TestCase
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
    public function it_gets_sub_merk_vehicle_vehicles(): void
    {
        $subMerkVehicle = SubMerkVehicle::factory()->create();
        $vehicles = Vehicle::factory()
            ->count(2)
            ->create([
                'sub_merk_vehicle_id' => $subMerkVehicle->id,
            ]);

        $response = $this->getJson(
            route('api.sub-merk-vehicles.vehicles.index', $subMerkVehicle)
        );

        $response->assertOk()->assertSee($vehicles[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_sub_merk_vehicle_vehicles(): void
    {
        $subMerkVehicle = SubMerkVehicle::factory()->create();
        $data = Vehicle::factory()
            ->make([
                'sub_merk_vehicle_id' => $subMerkVehicle->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.sub-merk-vehicles.vehicles.store', $subMerkVehicle),
            $data
        );

        unset($data['status']);

        $this->assertDatabaseHas('vehicles', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $vehicle = Vehicle::latest('id')->first();

        $this->assertEquals($subMerkVehicle->id, $vehicle->sub_merk_vehicle_id);
    }
}

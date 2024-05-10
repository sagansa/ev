<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\TypeVehicle;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TypeVehicleVehiclesTest extends TestCase
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
    public function it_gets_type_vehicle_vehicles(): void
    {
        $typeVehicle = TypeVehicle::factory()->create();
        $vehicles = Vehicle::factory()
            ->count(2)
            ->create([
                'type_vehicle_id' => $typeVehicle->id,
            ]);

        $response = $this->getJson(
            route('api.type-vehicles.vehicles.index', $typeVehicle)
        );

        $response->assertOk()->assertSee($vehicles[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_type_vehicle_vehicles(): void
    {
        $typeVehicle = TypeVehicle::factory()->create();
        $data = Vehicle::factory()
            ->make([
                'type_vehicle_id' => $typeVehicle->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.type-vehicles.vehicles.store', $typeVehicle),
            $data
        );

        unset($data['status']);

        $this->assertDatabaseHas('vehicles', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $vehicle = Vehicle::latest('id')->first();

        $this->assertEquals($typeVehicle->id, $vehicle->type_vehicle_id);
    }
}

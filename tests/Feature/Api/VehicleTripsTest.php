<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Trip;
use App\Models\Vehicle;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VehicleTripsTest extends TestCase
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
    public function it_gets_vehicle_trips(): void
    {
        $vehicle = Vehicle::factory()->create();
        $trips = Trip::factory()
            ->count(2)
            ->create([
                'vehicle_id' => $vehicle->id,
            ]);

        $response = $this->getJson(route('api.vehicles.trips.index', $vehicle));

        $response->assertOk()->assertSee($trips[0]->from);
    }

    /**
     * @test
     */
    public function it_stores_the_vehicle_trips(): void
    {
        $vehicle = Vehicle::factory()->create();
        $data = Trip::factory()
            ->make([
                'vehicle_id' => $vehicle->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.vehicles.trips.store', $vehicle),
            $data
        );

        $this->assertDatabaseHas('trips', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $trip = Trip::latest('id')->first();

        $this->assertEquals($vehicle->id, $trip->vehicle_id);
    }
}

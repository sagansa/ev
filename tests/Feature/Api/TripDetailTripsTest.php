<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Trip;
use App\Models\DetailTrip;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TripDetailTripsTest extends TestCase
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
    public function it_gets_trip_detail_trips(): void
    {
        $trip = Trip::factory()->create();
        $detailTrips = DetailTrip::factory()
            ->count(2)
            ->create([
                'trip_id' => $trip->id,
            ]);

        $response = $this->getJson(
            route('api.trips.detail-trips.index', $trip)
        );

        $response->assertOk()->assertSee($detailTrips[0]->notes);
    }

    /**
     * @test
     */
    public function it_stores_the_trip_detail_trips(): void
    {
        $trip = Trip::factory()->create();
        $data = DetailTrip::factory()
            ->make([
                'trip_id' => $trip->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.trips.detail-trips.store', $trip),
            $data
        );

        unset($data['trip_id']);
        unset($data['charger_location_id']);
        unset($data['odometer_start']);
        unset($data['odometer_end']);
        unset($data['battery_start']);
        unset($data['battery_end']);
        unset($data['notes']);

        $this->assertDatabaseHas('detail_trips', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $detailTrip = DetailTrip::latest('id')->first();

        $this->assertEquals($trip->id, $detailTrip->trip_id);
    }
}

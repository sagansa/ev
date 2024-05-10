<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\DetailTrip;
use App\Models\ChargerLocation;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChargerLocationDetailTripsTest extends TestCase
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
    public function it_gets_charger_location_detail_trips(): void
    {
        $chargerLocation = ChargerLocation::factory()->create();
        $detailTrips = DetailTrip::factory()
            ->count(2)
            ->create([
                'charger_location_id' => $chargerLocation->id,
            ]);

        $response = $this->getJson(
            route('api.charger-locations.detail-trips.index', $chargerLocation)
        );

        $response->assertOk()->assertSee($detailTrips[0]->notes);
    }

    /**
     * @test
     */
    public function it_stores_the_charger_location_detail_trips(): void
    {
        $chargerLocation = ChargerLocation::factory()->create();
        $data = DetailTrip::factory()
            ->make([
                'charger_location_id' => $chargerLocation->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.charger-locations.detail-trips.store', $chargerLocation),
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

        $this->assertEquals(
            $chargerLocation->id,
            $detailTrip->charger_location_id
        );
    }
}

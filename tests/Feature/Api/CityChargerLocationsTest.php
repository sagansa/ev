<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\City;
use App\Models\ChargerLocation;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CityChargerLocationsTest extends TestCase
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
    public function it_gets_city_charger_locations(): void
    {
        $city = City::factory()->create();
        $chargerLocations = ChargerLocation::factory()
            ->count(2)
            ->create([
                'city_id' => $city->id,
            ]);

        $response = $this->getJson(
            route('api.cities.charger-locations.index', $city)
        );

        $response->assertOk()->assertSee($chargerLocations[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_city_charger_locations(): void
    {
        $city = City::factory()->create();
        $data = ChargerLocation::factory()
            ->make([
                'city_id' => $city->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.cities.charger-locations.store', $city),
            $data
        );

        unset($data['user_id']);

        $this->assertDatabaseHas('charger_locations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $chargerLocation = ChargerLocation::latest('id')->first();

        $this->assertEquals($city->id, $chargerLocation->city_id);
    }
}

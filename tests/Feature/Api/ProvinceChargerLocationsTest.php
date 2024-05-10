<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Province;
use App\Models\ChargerLocation;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProvinceChargerLocationsTest extends TestCase
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
    public function it_gets_province_charger_locations(): void
    {
        $province = Province::factory()->create();
        $chargerLocations = ChargerLocation::factory()
            ->count(2)
            ->create([
                'province_id' => $province->id,
            ]);

        $response = $this->getJson(
            route('api.provinces.charger-locations.index', $province)
        );

        $response->assertOk()->assertSee($chargerLocations[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_province_charger_locations(): void
    {
        $province = Province::factory()->create();
        $data = ChargerLocation::factory()
            ->make([
                'province_id' => $province->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.provinces.charger-locations.store', $province),
            $data
        );

        unset($data['user_id']);

        $this->assertDatabaseHas('charger_locations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $chargerLocation = ChargerLocation::latest('id')->first();

        $this->assertEquals($province->id, $chargerLocation->province_id);
    }
}

<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Provider;
use App\Models\ChargerLocation;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProviderChargerLocationsTest extends TestCase
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
    public function it_gets_provider_charger_locations(): void
    {
        $provider = Provider::factory()->create();
        $chargerLocations = ChargerLocation::factory()
            ->count(2)
            ->create([
                'provider_id' => $provider->id,
            ]);

        $response = $this->getJson(
            route('api.providers.charger-locations.index', $provider)
        );

        $response->assertOk()->assertSee($chargerLocations[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_provider_charger_locations(): void
    {
        $provider = Provider::factory()->create();
        $data = ChargerLocation::factory()
            ->make([
                'provider_id' => $provider->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.providers.charger-locations.store', $provider),
            $data
        );

        unset($data['user_id']);

        $this->assertDatabaseHas('charger_locations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $chargerLocation = ChargerLocation::latest('id')->first();

        $this->assertEquals($provider->id, $chargerLocation->provider_id);
    }
}

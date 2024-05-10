<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ChargerLocation;

use App\Models\City;
use App\Models\Provider;
use App\Models\Province;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChargerLocationTest extends TestCase
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
    public function it_gets_charger_locations_list(): void
    {
        $chargerLocations = ChargerLocation::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.charger-locations.index'));

        $response->assertOk()->assertSee($chargerLocations[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_charger_location(): void
    {
        $data = ChargerLocation::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.charger-locations.store'),
            $data
        );

        unset($data['user_id']);

        $this->assertDatabaseHas('charger_locations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_charger_location(): void
    {
        $chargerLocation = ChargerLocation::factory()->create();

        $provider = Provider::factory()->create();
        $city = City::factory()->create();
        $province = Province::factory()->create();
        $user = User::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'provider_id' => $this->faker->uuid(),
            'location_on' => 'public',
            'status' => 'not verified',
            'description' => $this->faker->sentence(15),
            'maps' => $this->faker->text(255),
            'system' => 'free',
            'parking' => 'yes',
            'coordinate' => $this->faker->text(100),
            'user_id' => $this->faker->uuid(),
            'provider_id' => $provider->id,
            'city_id' => $city->id,
            'province_id' => $province->id,
            'user_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.charger-locations.update', $chargerLocation),
            $data
        );

        unset($data['user_id']);

        $data['id'] = $chargerLocation->id;

        $this->assertDatabaseHas('charger_locations', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_charger_location(): void
    {
        $chargerLocation = ChargerLocation::factory()->create();

        $response = $this->deleteJson(
            route('api.charger-locations.destroy', $chargerLocation)
        );

        $this->assertModelMissing($chargerLocation);

        $response->assertNoContent();
    }
}

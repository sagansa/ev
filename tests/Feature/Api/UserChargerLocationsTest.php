<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ChargerLocation;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserChargerLocationsTest extends TestCase
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
    public function it_gets_user_charger_locations(): void
    {
        $user = User::factory()->create();
        $chargerLocations = ChargerLocation::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.charger-locations.index', $user)
        );

        $response->assertOk()->assertSee($chargerLocations[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_user_charger_locations(): void
    {
        $user = User::factory()->create();
        $data = ChargerLocation::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.charger-locations.store', $user),
            $data
        );

        unset($data['user_id']);

        $this->assertDatabaseHas('charger_locations', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $chargerLocation = ChargerLocation::latest('id')->first();

        $this->assertEquals($user->id, $chargerLocation->user_id);
    }
}

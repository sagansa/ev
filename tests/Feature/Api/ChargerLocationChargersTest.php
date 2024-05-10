<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Charger;
use App\Models\ChargerLocation;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChargerLocationChargersTest extends TestCase
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
    public function it_gets_charger_location_chargers(): void
    {
        $chargerLocation = ChargerLocation::factory()->create();
        $chargers = Charger::factory()
            ->count(2)
            ->create([
                'charger_location_id' => $chargerLocation->id,
            ]);

        $response = $this->getJson(
            route('api.charger-locations.chargers.index', $chargerLocation)
        );

        $response->assertOk()->assertSee($chargers[0]->power);
    }

    /**
     * @test
     */
    public function it_stores_the_charger_location_chargers(): void
    {
        $chargerLocation = ChargerLocation::factory()->create();
        $data = Charger::factory()
            ->make([
                'charger_location_id' => $chargerLocation->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.charger-locations.chargers.store', $chargerLocation),
            $data
        );

        $this->assertDatabaseHas('chargers', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $charger = Charger::latest('id')->first();

        $this->assertEquals(
            $chargerLocation->id,
            $charger->charger_location_id
        );
    }
}

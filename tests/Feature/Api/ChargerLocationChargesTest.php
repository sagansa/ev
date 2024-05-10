<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Charge;
use App\Models\ChargerLocation;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChargerLocationChargesTest extends TestCase
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
    public function it_gets_charger_location_charges(): void
    {
        $chargerLocation = ChargerLocation::factory()->create();
        $charges = Charge::factory()
            ->count(2)
            ->create([
                'charger_location_id' => $chargerLocation->id,
            ]);

        $response = $this->getJson(
            route('api.charger-locations.charges.index', $chargerLocation)
        );

        $response->assertOk()->assertSee($charges[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_charger_location_charges(): void
    {
        $chargerLocation = ChargerLocation::factory()->create();
        $data = Charge::factory()
            ->make([
                'charger_location_id' => $chargerLocation->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.charger-locations.charges.store', $chargerLocation),
            $data
        );

        $this->assertDatabaseHas('charges', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $charge = Charge::latest('id')->first();

        $this->assertEquals($chargerLocation->id, $charge->charger_location_id);
    }
}

<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Charger;
use App\Models\ChargerType;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChargerTypeChargersTest extends TestCase
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
    public function it_gets_charger_type_chargers(): void
    {
        $chargerType = ChargerType::factory()->create();
        $chargers = Charger::factory()
            ->count(2)
            ->create([
                'charger_type_id' => $chargerType->id,
            ]);

        $response = $this->getJson(
            route('api.charger-types.chargers.index', $chargerType)
        );

        $response->assertOk()->assertSee($chargers[0]->power);
    }

    /**
     * @test
     */
    public function it_stores_the_charger_type_chargers(): void
    {
        $chargerType = ChargerType::factory()->create();
        $data = Charger::factory()
            ->make([
                'charger_type_id' => $chargerType->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.charger-types.chargers.store', $chargerType),
            $data
        );

        $this->assertDatabaseHas('chargers', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $charger = Charger::latest('id')->first();

        $this->assertEquals($chargerType->id, $charger->charger_type_id);
    }
}

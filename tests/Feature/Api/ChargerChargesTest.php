<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Charge;
use App\Models\Charger;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChargerChargesTest extends TestCase
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
    public function it_gets_charger_charges(): void
    {
        $charger = Charger::factory()->create();
        $charges = Charge::factory()
            ->count(2)
            ->create([
                'charger_id' => $charger->id,
            ]);

        $response = $this->getJson(
            route('api.chargers.charges.index', $charger)
        );

        $response->assertOk()->assertSee($charges[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_charger_charges(): void
    {
        $charger = Charger::factory()->create();
        $data = Charge::factory()
            ->make([
                'charger_id' => $charger->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.chargers.charges.store', $charger),
            $data
        );

        $this->assertDatabaseHas('charges', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $charge = Charge::latest('id')->first();

        $this->assertEquals($charger->id, $charge->charger_id);
    }
}

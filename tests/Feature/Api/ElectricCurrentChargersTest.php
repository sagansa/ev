<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Charger;
use App\Models\ElectricCurrent;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ElectricCurrentChargersTest extends TestCase
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
    public function it_gets_electric_current_chargers(): void
    {
        $electricCurrent = ElectricCurrent::factory()->create();
        $chargers = Charger::factory()
            ->count(2)
            ->create([
                'electric_current_id' => $electricCurrent->id,
            ]);

        $response = $this->getJson(
            route('api.electric-currents.chargers.index', $electricCurrent)
        );

        $response->assertOk()->assertSee($chargers[0]->power);
    }

    /**
     * @test
     */
    public function it_stores_the_electric_current_chargers(): void
    {
        $electricCurrent = ElectricCurrent::factory()->create();
        $data = Charger::factory()
            ->make([
                'electric_current_id' => $electricCurrent->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.electric-currents.chargers.store', $electricCurrent),
            $data
        );

        $this->assertDatabaseHas('chargers', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $charger = Charger::latest('id')->first();

        $this->assertEquals(
            $electricCurrent->id,
            $charger->electric_current_id
        );
    }
}

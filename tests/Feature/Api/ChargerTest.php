<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Charger;

use App\Models\ChargerType;
use App\Models\ChargerLocation;
use App\Models\ElectricCurrent;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChargerTest extends TestCase
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
    public function it_gets_chargers_list(): void
    {
        $chargers = Charger::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.chargers.index'));

        $response->assertOk()->assertSee($chargers[0]->power);
    }

    /**
     * @test
     */
    public function it_stores_the_charger(): void
    {
        $data = Charger::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.chargers.store'), $data);

        $this->assertDatabaseHas('chargers', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_charger(): void
    {
        $charger = Charger::factory()->create();

        $chargerLocation = ChargerLocation::factory()->create();
        $chargerType = ChargerType::factory()->create();
        $user = User::factory()->create();
        $electricCurrent = ElectricCurrent::factory()->create();

        $data = [
            'charger_location_id' => $this->faker->uuid(),
            'charger_type_id' => $this->faker->randomNumber(),
            'power' => $this->faker->text(10),
            'unit' => $this->faker->numberBetween(0, 127),
            'charge_cost' => $this->faker->randomNumber(0),
            'PPJ' => $this->faker->randomNumber(0),
            'admin_cost' => $this->faker->randomNumber(0),
            'PPN' => 'yes',
            'status' => 'not verified',
            'user_id' => $this->faker->uuid(),
            'charger_location_id' => $chargerLocation->id,
            'charger_type_id' => $chargerType->id,
            'user_id' => $user->id,
            'electric_current_id' => $electricCurrent->id,
        ];

        $response = $this->putJson(
            route('api.chargers.update', $charger),
            $data
        );

        $data['id'] = $charger->id;

        $this->assertDatabaseHas('chargers', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_charger(): void
    {
        $charger = Charger::factory()->create();

        $response = $this->deleteJson(route('api.chargers.destroy', $charger));

        $this->assertModelMissing($charger);

        $response->assertNoContent();
    }
}

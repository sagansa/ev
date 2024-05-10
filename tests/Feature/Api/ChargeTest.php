<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Charge;

use App\Models\Vehicle;
use App\Models\Charger;
use App\Models\ChargerLocation;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChargeTest extends TestCase
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
    public function it_gets_charges_list(): void
    {
        $charges = Charge::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.charges.index'));

        $response->assertOk()->assertSee($charges[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_charge(): void
    {
        $data = Charge::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.charges.store'), $data);

        $this->assertDatabaseHas('charges', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_charge(): void
    {
        $charge = Charge::factory()->create();

        $vehicle = Vehicle::factory()->create();
        $chargerLocation = ChargerLocation::factory()->create();
        $charger = Charger::factory()->create();
        $user = User::factory()->create();

        $data = [
            'vehicle_id' => $this->faker->uuid(),
            'date' => $this->faker->date(),
            'charger_location_id' => $this->faker->uuid(),
            'charger_id' => $this->faker->uuid(),
            'km_now' => $this->faker->randomNumber(0),
            'km_before' => $this->faker->randomNumber(0),
            'battery_start_charging' => $this->faker->randomNumber(0),
            'battery_finish_charging' => $this->faker->randomNumber(0),
            'battery_finish_before' => $this->faker->randomNumber(0),
            'parking' => $this->faker->randomNumber(0),
            'kWh' => $this->faker->randomNumber(0),
            'PPJ' => $this->faker->randomNumber(0),
            'PPN' => $this->faker->randomNumber(0),
            'admin_cost' => $this->faker->randomNumber(0),
            'total_cost' => $this->faker->randomNumber(0),
            'user_id' => $this->faker->uuid(),
            'vehicle_id' => $vehicle->id,
            'charger_location_id' => $chargerLocation->id,
            'charger_id' => $charger->id,
            'user_id' => $user->id,
        ];

        $response = $this->putJson(route('api.charges.update', $charge), $data);

        $data['id'] = $charge->id;

        $this->assertDatabaseHas('charges', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_charge(): void
    {
        $charge = Charge::factory()->create();

        $response = $this->deleteJson(route('api.charges.destroy', $charge));

        $this->assertModelMissing($charge);

        $response->assertNoContent();
    }
}

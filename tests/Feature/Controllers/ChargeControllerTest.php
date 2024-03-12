<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Charge;

use App\Models\Vehicle;
use App\Models\Charger;
use App\Models\ChargerLocation;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChargeControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_charges(): void
    {
        $charges = Charge::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('charges.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.charges.index')
            ->assertViewHas('charges');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_charge(): void
    {
        $response = $this->get(route('charges.create'));

        $response->assertOk()->assertViewIs('app.charges.create');
    }

    /**
     * @test
     */
    public function it_stores_the_charge(): void
    {
        $data = Charge::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('charges.store'), $data);

        $this->assertDatabaseHas('charges', $data);

        $charge = Charge::latest('id')->first();

        $response->assertRedirect(route('charges.edit', $charge));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_charge(): void
    {
        $charge = Charge::factory()->create();

        $response = $this->get(route('charges.show', $charge));

        $response
            ->assertOk()
            ->assertViewIs('app.charges.show')
            ->assertViewHas('charge');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_charge(): void
    {
        $charge = Charge::factory()->create();

        $response = $this->get(route('charges.edit', $charge));

        $response
            ->assertOk()
            ->assertViewIs('app.charges.edit')
            ->assertViewHas('charge');
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
            'vehicle_id' => $vehicle->id,
            'charger_location_id' => $chargerLocation->id,
            'charger_id' => $charger->id,
            'user_id' => $user->id,
        ];

        $response = $this->put(route('charges.update', $charge), $data);

        $data['id'] = $charge->id;

        $this->assertDatabaseHas('charges', $data);

        $response->assertRedirect(route('charges.edit', $charge));
    }

    /**
     * @test
     */
    public function it_deletes_the_charge(): void
    {
        $charge = Charge::factory()->create();

        $response = $this->delete(route('charges.destroy', $charge));

        $response->assertRedirect(route('charges.index'));

        $this->assertModelMissing($charge);
    }
}

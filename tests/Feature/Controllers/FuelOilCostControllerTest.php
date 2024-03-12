<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\FuelOilCost;

use App\Models\Vehicle;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FuelOilCostControllerTest extends TestCase
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
    public function it_displays_index_view_with_fuel_oil_costs(): void
    {
        $fuelOilCosts = FuelOilCost::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('fuel-oil-costs.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.fuel_oil_costs.index')
            ->assertViewHas('fuelOilCosts');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_fuel_oil_cost(): void
    {
        $response = $this->get(route('fuel-oil-costs.create'));

        $response->assertOk()->assertViewIs('app.fuel_oil_costs.create');
    }

    /**
     * @test
     */
    public function it_stores_the_fuel_oil_cost(): void
    {
        $data = FuelOilCost::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('fuel-oil-costs.store'), $data);

        $this->assertDatabaseHas('fuel_oil_costs', $data);

        $fuelOilCost = FuelOilCost::latest('id')->first();

        $response->assertRedirect(route('fuel-oil-costs.edit', $fuelOilCost));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_fuel_oil_cost(): void
    {
        $fuelOilCost = FuelOilCost::factory()->create();

        $response = $this->get(route('fuel-oil-costs.show', $fuelOilCost));

        $response
            ->assertOk()
            ->assertViewIs('app.fuel_oil_costs.show')
            ->assertViewHas('fuelOilCost');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_fuel_oil_cost(): void
    {
        $fuelOilCost = FuelOilCost::factory()->create();

        $response = $this->get(route('fuel-oil-costs.edit', $fuelOilCost));

        $response
            ->assertOk()
            ->assertViewIs('app.fuel_oil_costs.edit')
            ->assertViewHas('fuelOilCost');
    }

    /**
     * @test
     */
    public function it_updates_the_fuel_oil_cost(): void
    {
        $fuelOilCost = FuelOilCost::factory()->create();

        $vehicle = Vehicle::factory()->create();
        $user = User::factory()->create();

        $data = [
            'vehicle_id' => $this->faker->uuid(),
            'date' => $this->faker->date(),
            'fuel_price' => $this->faker->randomNumber(0),
            'km_start' => $this->faker->randomNumber(0),
            'km_end' => $this->faker->randomNumber(0),
            'vehicle_id' => $vehicle->id,
            'user_id' => $user->id,
        ];

        $response = $this->put(
            route('fuel-oil-costs.update', $fuelOilCost),
            $data
        );

        $data['id'] = $fuelOilCost->id;

        $this->assertDatabaseHas('fuel_oil_costs', $data);

        $response->assertRedirect(route('fuel-oil-costs.edit', $fuelOilCost));
    }

    /**
     * @test
     */
    public function it_deletes_the_fuel_oil_cost(): void
    {
        $fuelOilCost = FuelOilCost::factory()->create();

        $response = $this->delete(
            route('fuel-oil-costs.destroy', $fuelOilCost)
        );

        $response->assertRedirect(route('fuel-oil-costs.index'));

        $this->assertModelMissing($fuelOilCost);
    }
}

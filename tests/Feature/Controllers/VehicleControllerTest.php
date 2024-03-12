<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Vehicle;

use App\Models\TypeVehicle;
use App\Models\MerkVehicle;
use App\Models\SubMerkVehicle;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VehicleControllerTest extends TestCase
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
    public function it_displays_index_view_with_vehicles(): void
    {
        $vehicles = Vehicle::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('vehicles.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.vehicles.index')
            ->assertViewHas('vehicles');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_vehicle(): void
    {
        $response = $this->get(route('vehicles.create'));

        $response->assertOk()->assertViewIs('app.vehicles.create');
    }

    /**
     * @test
     */
    public function it_stores_the_vehicle(): void
    {
        $data = Vehicle::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('vehicles.store'), $data);

        unset($data['status']);

        $this->assertDatabaseHas('vehicles', $data);

        $vehicle = Vehicle::latest('id')->first();

        $response->assertRedirect(route('vehicles.edit', $vehicle));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_vehicle(): void
    {
        $vehicle = Vehicle::factory()->create();

        $response = $this->get(route('vehicles.show', $vehicle));

        $response
            ->assertOk()
            ->assertViewIs('app.vehicles.show')
            ->assertViewHas('vehicle');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_vehicle(): void
    {
        $vehicle = Vehicle::factory()->create();

        $response = $this->get(route('vehicles.edit', $vehicle));

        $response
            ->assertOk()
            ->assertViewIs('app.vehicles.edit')
            ->assertViewHas('vehicle');
    }

    /**
     * @test
     */
    public function it_updates_the_vehicle(): void
    {
        $vehicle = Vehicle::factory()->create();

        $typeVehicle = TypeVehicle::factory()->create();
        $merkVehicle = MerkVehicle::factory()->create();
        $subMerkVehicle = SubMerkVehicle::factory()->create();
        $user = User::factory()->create();

        $data = [
            'type_vehicle_id' => $this->faker->randomNumber(),
            'merk_vehicle_id' => $this->faker->randomNumber(),
            'sub_merk_vehicle_id' => $this->faker->randomNumber(),
            'license_plate' => $this->faker->text(10),
            'ownership' => $this->faker->date(),
            'status' => 'active',
            'type_vehicle_id' => $typeVehicle->id,
            'merk_vehicle_id' => $merkVehicle->id,
            'sub_merk_vehicle_id' => $subMerkVehicle->id,
            'user_id' => $user->id,
        ];

        $response = $this->put(route('vehicles.update', $vehicle), $data);

        unset($data['status']);

        $data['id'] = $vehicle->id;

        $this->assertDatabaseHas('vehicles', $data);

        $response->assertRedirect(route('vehicles.edit', $vehicle));
    }

    /**
     * @test
     */
    public function it_deletes_the_vehicle(): void
    {
        $vehicle = Vehicle::factory()->create();

        $response = $this->delete(route('vehicles.destroy', $vehicle));

        $response->assertRedirect(route('vehicles.index'));

        $this->assertModelMissing($vehicle);
    }
}

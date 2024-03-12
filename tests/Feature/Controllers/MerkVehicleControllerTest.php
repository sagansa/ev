<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\MerkVehicle;

use App\Models\TypeVehicle;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MerkVehicleControllerTest extends TestCase
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
    public function it_displays_index_view_with_merk_vehicles(): void
    {
        $merkVehicles = MerkVehicle::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('merk-vehicles.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.merk_vehicles.index')
            ->assertViewHas('merkVehicles');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_merk_vehicle(): void
    {
        $response = $this->get(route('merk-vehicles.create'));

        $response->assertOk()->assertViewIs('app.merk_vehicles.create');
    }

    /**
     * @test
     */
    public function it_stores_the_merk_vehicle(): void
    {
        $data = MerkVehicle::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('merk-vehicles.store'), $data);

        $this->assertDatabaseHas('merk_vehicles', $data);

        $merkVehicle = MerkVehicle::latest('id')->first();

        $response->assertRedirect(route('merk-vehicles.edit', $merkVehicle));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_merk_vehicle(): void
    {
        $merkVehicle = MerkVehicle::factory()->create();

        $response = $this->get(route('merk-vehicles.show', $merkVehicle));

        $response
            ->assertOk()
            ->assertViewIs('app.merk_vehicles.show')
            ->assertViewHas('merkVehicle');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_merk_vehicle(): void
    {
        $merkVehicle = MerkVehicle::factory()->create();

        $response = $this->get(route('merk-vehicles.edit', $merkVehicle));

        $response
            ->assertOk()
            ->assertViewIs('app.merk_vehicles.edit')
            ->assertViewHas('merkVehicle');
    }

    /**
     * @test
     */
    public function it_updates_the_merk_vehicle(): void
    {
        $merkVehicle = MerkVehicle::factory()->create();

        $typeVehicle = TypeVehicle::factory()->create();

        $data = [
            'type_vehicle_id' => $this->faker->randomNumber(),
            'merk' => $this->faker->unique->text(20),
            'type_vehicle_id' => $typeVehicle->id,
        ];

        $response = $this->put(
            route('merk-vehicles.update', $merkVehicle),
            $data
        );

        $data['id'] = $merkVehicle->id;

        $this->assertDatabaseHas('merk_vehicles', $data);

        $response->assertRedirect(route('merk-vehicles.edit', $merkVehicle));
    }

    /**
     * @test
     */
    public function it_deletes_the_merk_vehicle(): void
    {
        $merkVehicle = MerkVehicle::factory()->create();

        $response = $this->delete(route('merk-vehicles.destroy', $merkVehicle));

        $response->assertRedirect(route('merk-vehicles.index'));

        $this->assertModelMissing($merkVehicle);
    }
}

<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\SubMerkVehicle;

use App\Models\TypeVehicle;
use App\Models\MerkVehicle;
use App\Models\ChargerType;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubMerkVehicleControllerTest extends TestCase
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
    public function it_displays_index_view_with_sub_merk_vehicles(): void
    {
        $subMerkVehicles = SubMerkVehicle::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('sub-merk-vehicles.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.sub_merk_vehicles.index')
            ->assertViewHas('subMerkVehicles');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_sub_merk_vehicle(): void
    {
        $response = $this->get(route('sub-merk-vehicles.create'));

        $response->assertOk()->assertViewIs('app.sub_merk_vehicles.create');
    }

    /**
     * @test
     */
    public function it_stores_the_sub_merk_vehicle(): void
    {
        $data = SubMerkVehicle::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('sub-merk-vehicles.store'), $data);

        $this->assertDatabaseHas('sub_merk_vehicles', $data);

        $subMerkVehicle = SubMerkVehicle::latest('id')->first();

        $response->assertRedirect(
            route('sub-merk-vehicles.edit', $subMerkVehicle)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_sub_merk_vehicle(): void
    {
        $subMerkVehicle = SubMerkVehicle::factory()->create();

        $response = $this->get(
            route('sub-merk-vehicles.show', $subMerkVehicle)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.sub_merk_vehicles.show')
            ->assertViewHas('subMerkVehicle');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_sub_merk_vehicle(): void
    {
        $subMerkVehicle = SubMerkVehicle::factory()->create();

        $response = $this->get(
            route('sub-merk-vehicles.edit', $subMerkVehicle)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.sub_merk_vehicles.edit')
            ->assertViewHas('subMerkVehicle');
    }

    /**
     * @test
     */
    public function it_updates_the_sub_merk_vehicle(): void
    {
        $subMerkVehicle = SubMerkVehicle::factory()->create();

        $typeVehicle = TypeVehicle::factory()->create();
        $merkVehicle = MerkVehicle::factory()->create();
        $chargerType = ChargerType::factory()->create();

        $data = [
            'type_vehicle_id' => $this->faker->randomNumber(),
            'merk_vehicle_id' => $this->faker->randomNumber(),
            'sub_merk' => $this->faker->unique->text(30),
            'charger_type_id' => $this->faker->randomNumber(),
            'battery_capacity' => $this->faker->randomNumber(1),
            'type_vehicle_id' => $typeVehicle->id,
            'merk_vehicle_id' => $merkVehicle->id,
            'charger_type_id' => $chargerType->id,
        ];

        $response = $this->put(
            route('sub-merk-vehicles.update', $subMerkVehicle),
            $data
        );

        $data['id'] = $subMerkVehicle->id;

        $this->assertDatabaseHas('sub_merk_vehicles', $data);

        $response->assertRedirect(
            route('sub-merk-vehicles.edit', $subMerkVehicle)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_sub_merk_vehicle(): void
    {
        $subMerkVehicle = SubMerkVehicle::factory()->create();

        $response = $this->delete(
            route('sub-merk-vehicles.destroy', $subMerkVehicle)
        );

        $response->assertRedirect(route('sub-merk-vehicles.index'));

        $this->assertModelMissing($subMerkVehicle);
    }
}

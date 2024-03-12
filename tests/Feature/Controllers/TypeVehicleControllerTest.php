<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\TypeVehicle;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TypeVehicleControllerTest extends TestCase
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
    public function it_displays_index_view_with_type_vehicles(): void
    {
        $typeVehicles = TypeVehicle::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('type-vehicles.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.type_vehicles.index')
            ->assertViewHas('typeVehicles');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_type_vehicle(): void
    {
        $response = $this->get(route('type-vehicles.create'));

        $response->assertOk()->assertViewIs('app.type_vehicles.create');
    }

    /**
     * @test
     */
    public function it_stores_the_type_vehicle(): void
    {
        $data = TypeVehicle::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('type-vehicles.store'), $data);

        $this->assertDatabaseHas('type_vehicles', $data);

        $typeVehicle = TypeVehicle::latest('id')->first();

        $response->assertRedirect(route('type-vehicles.edit', $typeVehicle));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_type_vehicle(): void
    {
        $typeVehicle = TypeVehicle::factory()->create();

        $response = $this->get(route('type-vehicles.show', $typeVehicle));

        $response
            ->assertOk()
            ->assertViewIs('app.type_vehicles.show')
            ->assertViewHas('typeVehicle');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_type_vehicle(): void
    {
        $typeVehicle = TypeVehicle::factory()->create();

        $response = $this->get(route('type-vehicles.edit', $typeVehicle));

        $response
            ->assertOk()
            ->assertViewIs('app.type_vehicles.edit')
            ->assertViewHas('typeVehicle');
    }

    /**
     * @test
     */
    public function it_updates_the_type_vehicle(): void
    {
        $typeVehicle = TypeVehicle::factory()->create();

        $data = [
            'type' => $this->faker->unique->text(20),
        ];

        $response = $this->put(
            route('type-vehicles.update', $typeVehicle),
            $data
        );

        $data['id'] = $typeVehicle->id;

        $this->assertDatabaseHas('type_vehicles', $data);

        $response->assertRedirect(route('type-vehicles.edit', $typeVehicle));
    }

    /**
     * @test
     */
    public function it_deletes_the_type_vehicle(): void
    {
        $typeVehicle = TypeVehicle::factory()->create();

        $response = $this->delete(route('type-vehicles.destroy', $typeVehicle));

        $response->assertRedirect(route('type-vehicles.index'));

        $this->assertModelMissing($typeVehicle);
    }
}

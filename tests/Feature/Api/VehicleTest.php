<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Vehicle;

use App\Models\TypeVehicle;
use App\Models\MerkVehicle;
use App\Models\SubMerkVehicle;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VehicleTest extends TestCase
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
    public function it_gets_vehicles_list(): void
    {
        $vehicles = Vehicle::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.vehicles.index'));

        $response->assertOk()->assertSee($vehicles[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_vehicle(): void
    {
        $data = Vehicle::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.vehicles.store'), $data);

        unset($data['status']);

        $this->assertDatabaseHas('vehicles', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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
            'user_id' => $this->faker->uuid(),
            'type_vehicle_id' => $typeVehicle->id,
            'merk_vehicle_id' => $merkVehicle->id,
            'sub_merk_vehicle_id' => $subMerkVehicle->id,
            'user_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.vehicles.update', $vehicle),
            $data
        );

        unset($data['status']);

        $data['id'] = $vehicle->id;

        $this->assertDatabaseHas('vehicles', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_vehicle(): void
    {
        $vehicle = Vehicle::factory()->create();

        $response = $this->deleteJson(route('api.vehicles.destroy', $vehicle));

        $this->assertModelMissing($vehicle);

        $response->assertNoContent();
    }
}

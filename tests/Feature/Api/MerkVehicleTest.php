<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\MerkVehicle;

use App\Models\TypeVehicle;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MerkVehicleTest extends TestCase
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
    public function it_gets_merk_vehicles_list(): void
    {
        $merkVehicles = MerkVehicle::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.merk-vehicles.index'));

        $response->assertOk()->assertSee($merkVehicles[0]->merk);
    }

    /**
     * @test
     */
    public function it_stores_the_merk_vehicle(): void
    {
        $data = MerkVehicle::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.merk-vehicles.store'), $data);

        $this->assertDatabaseHas('merk_vehicles', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.merk-vehicles.update', $merkVehicle),
            $data
        );

        $data['id'] = $merkVehicle->id;

        $this->assertDatabaseHas('merk_vehicles', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_merk_vehicle(): void
    {
        $merkVehicle = MerkVehicle::factory()->create();

        $response = $this->deleteJson(
            route('api.merk-vehicles.destroy', $merkVehicle)
        );

        $this->assertModelMissing($merkVehicle);

        $response->assertNoContent();
    }
}

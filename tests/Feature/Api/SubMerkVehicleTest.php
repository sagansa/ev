<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SubMerkVehicle;

use App\Models\TypeVehicle;
use App\Models\MerkVehicle;
use App\Models\ChargerType;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubMerkVehicleTest extends TestCase
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
    public function it_gets_sub_merk_vehicles_list(): void
    {
        $subMerkVehicles = SubMerkVehicle::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.sub-merk-vehicles.index'));

        $response->assertOk()->assertSee($subMerkVehicles[0]->sub_merk);
    }

    /**
     * @test
     */
    public function it_stores_the_sub_merk_vehicle(): void
    {
        $data = SubMerkVehicle::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.sub-merk-vehicles.store'),
            $data
        );

        $this->assertDatabaseHas('sub_merk_vehicles', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.sub-merk-vehicles.update', $subMerkVehicle),
            $data
        );

        $data['id'] = $subMerkVehicle->id;

        $this->assertDatabaseHas('sub_merk_vehicles', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_sub_merk_vehicle(): void
    {
        $subMerkVehicle = SubMerkVehicle::factory()->create();

        $response = $this->deleteJson(
            route('api.sub-merk-vehicles.destroy', $subMerkVehicle)
        );

        $this->assertModelMissing($subMerkVehicle);

        $response->assertNoContent();
    }
}

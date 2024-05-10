<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\TypeVehicle;
use App\Models\MerkVehicle;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TypeVehicleMerkVehiclesTest extends TestCase
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
    public function it_gets_type_vehicle_merk_vehicles(): void
    {
        $typeVehicle = TypeVehicle::factory()->create();
        $merkVehicles = MerkVehicle::factory()
            ->count(2)
            ->create([
                'type_vehicle_id' => $typeVehicle->id,
            ]);

        $response = $this->getJson(
            route('api.type-vehicles.merk-vehicles.index', $typeVehicle)
        );

        $response->assertOk()->assertSee($merkVehicles[0]->merk);
    }

    /**
     * @test
     */
    public function it_stores_the_type_vehicle_merk_vehicles(): void
    {
        $typeVehicle = TypeVehicle::factory()->create();
        $data = MerkVehicle::factory()
            ->make([
                'type_vehicle_id' => $typeVehicle->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.type-vehicles.merk-vehicles.store', $typeVehicle),
            $data
        );

        $this->assertDatabaseHas('merk_vehicles', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $merkVehicle = MerkVehicle::latest('id')->first();

        $this->assertEquals($typeVehicle->id, $merkVehicle->type_vehicle_id);
    }
}

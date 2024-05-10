<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\TypeVehicle;
use App\Models\SubMerkVehicle;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TypeVehicleSubMerkVehiclesTest extends TestCase
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
    public function it_gets_type_vehicle_sub_merk_vehicles(): void
    {
        $typeVehicle = TypeVehicle::factory()->create();
        $subMerkVehicles = SubMerkVehicle::factory()
            ->count(2)
            ->create([
                'type_vehicle_id' => $typeVehicle->id,
            ]);

        $response = $this->getJson(
            route('api.type-vehicles.sub-merk-vehicles.index', $typeVehicle)
        );

        $response->assertOk()->assertSee($subMerkVehicles[0]->sub_merk);
    }

    /**
     * @test
     */
    public function it_stores_the_type_vehicle_sub_merk_vehicles(): void
    {
        $typeVehicle = TypeVehicle::factory()->create();
        $data = SubMerkVehicle::factory()
            ->make([
                'type_vehicle_id' => $typeVehicle->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.type-vehicles.sub-merk-vehicles.store', $typeVehicle),
            $data
        );

        $this->assertDatabaseHas('sub_merk_vehicles', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $subMerkVehicle = SubMerkVehicle::latest('id')->first();

        $this->assertEquals($typeVehicle->id, $subMerkVehicle->type_vehicle_id);
    }
}

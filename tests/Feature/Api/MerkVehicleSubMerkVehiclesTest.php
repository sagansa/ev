<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\MerkVehicle;
use App\Models\SubMerkVehicle;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MerkVehicleSubMerkVehiclesTest extends TestCase
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
    public function it_gets_merk_vehicle_sub_merk_vehicles(): void
    {
        $merkVehicle = MerkVehicle::factory()->create();
        $subMerkVehicles = SubMerkVehicle::factory()
            ->count(2)
            ->create([
                'merk_vehicle_id' => $merkVehicle->id,
            ]);

        $response = $this->getJson(
            route('api.merk-vehicles.sub-merk-vehicles.index', $merkVehicle)
        );

        $response->assertOk()->assertSee($subMerkVehicles[0]->sub_merk);
    }

    /**
     * @test
     */
    public function it_stores_the_merk_vehicle_sub_merk_vehicles(): void
    {
        $merkVehicle = MerkVehicle::factory()->create();
        $data = SubMerkVehicle::factory()
            ->make([
                'merk_vehicle_id' => $merkVehicle->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.merk-vehicles.sub-merk-vehicles.store', $merkVehicle),
            $data
        );

        $this->assertDatabaseHas('sub_merk_vehicles', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $subMerkVehicle = SubMerkVehicle::latest('id')->first();

        $this->assertEquals($merkVehicle->id, $subMerkVehicle->merk_vehicle_id);
    }
}

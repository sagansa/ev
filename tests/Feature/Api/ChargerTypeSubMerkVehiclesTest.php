<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ChargerType;
use App\Models\SubMerkVehicle;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChargerTypeSubMerkVehiclesTest extends TestCase
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
    public function it_gets_charger_type_sub_merk_vehicles(): void
    {
        $chargerType = ChargerType::factory()->create();
        $subMerkVehicles = SubMerkVehicle::factory()
            ->count(2)
            ->create([
                'charger_type_id' => $chargerType->id,
            ]);

        $response = $this->getJson(
            route('api.charger-types.sub-merk-vehicles.index', $chargerType)
        );

        $response->assertOk()->assertSee($subMerkVehicles[0]->sub_merk);
    }

    /**
     * @test
     */
    public function it_stores_the_charger_type_sub_merk_vehicles(): void
    {
        $chargerType = ChargerType::factory()->create();
        $data = SubMerkVehicle::factory()
            ->make([
                'charger_type_id' => $chargerType->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.charger-types.sub-merk-vehicles.store', $chargerType),
            $data
        );

        $this->assertDatabaseHas('sub_merk_vehicles', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $subMerkVehicle = SubMerkVehicle::latest('id')->first();

        $this->assertEquals($chargerType->id, $subMerkVehicle->charger_type_id);
    }
}

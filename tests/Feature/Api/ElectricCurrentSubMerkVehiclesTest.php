<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SubMerkVehicle;
use App\Models\ElectricCurrent;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ElectricCurrentSubMerkVehiclesTest extends TestCase
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
    public function it_gets_electric_current_sub_merk_vehicles(): void
    {
        $electricCurrent = ElectricCurrent::factory()->create();
        $subMerkVehicle = SubMerkVehicle::factory()->create();

        $electricCurrent->subMerkVehicles()->attach($subMerkVehicle);

        $response = $this->getJson(
            route(
                'api.electric-currents.sub-merk-vehicles.index',
                $electricCurrent
            )
        );

        $response->assertOk()->assertSee($subMerkVehicle->sub_merk);
    }

    /**
     * @test
     */
    public function it_can_attach_sub_merk_vehicles_to_electric_current(): void
    {
        $electricCurrent = ElectricCurrent::factory()->create();
        $subMerkVehicle = SubMerkVehicle::factory()->create();

        $response = $this->postJson(
            route('api.electric-currents.sub-merk-vehicles.store', [
                $electricCurrent,
                $subMerkVehicle,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $electricCurrent
                ->subMerkVehicles()
                ->where('sub_merk_vehicles.id', $subMerkVehicle->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_sub_merk_vehicles_from_electric_current(): void
    {
        $electricCurrent = ElectricCurrent::factory()->create();
        $subMerkVehicle = SubMerkVehicle::factory()->create();

        $response = $this->deleteJson(
            route('api.electric-currents.sub-merk-vehicles.store', [
                $electricCurrent,
                $subMerkVehicle,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $electricCurrent
                ->subMerkVehicles()
                ->where('sub_merk_vehicles.id', $subMerkVehicle->id)
                ->exists()
        );
    }
}

<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\SubMerkVehicle;
use App\Models\ElectricCurrent;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubMerkVehicleElectricCurrentsTest extends TestCase
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
    public function it_gets_sub_merk_vehicle_electric_currents(): void
    {
        $subMerkVehicle = SubMerkVehicle::factory()->create();
        $electricCurrent = ElectricCurrent::factory()->create();

        $subMerkVehicle->electricCurrents()->attach($electricCurrent);

        $response = $this->getJson(
            route(
                'api.sub-merk-vehicles.electric-currents.index',
                $subMerkVehicle
            )
        );

        $response->assertOk()->assertSee($electricCurrent->name);
    }

    /**
     * @test
     */
    public function it_can_attach_electric_currents_to_sub_merk_vehicle(): void
    {
        $subMerkVehicle = SubMerkVehicle::factory()->create();
        $electricCurrent = ElectricCurrent::factory()->create();

        $response = $this->postJson(
            route('api.sub-merk-vehicles.electric-currents.store', [
                $subMerkVehicle,
                $electricCurrent,
            ])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $subMerkVehicle
                ->electricCurrents()
                ->where('electric_currents.id', $electricCurrent->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_electric_currents_from_sub_merk_vehicle(): void
    {
        $subMerkVehicle = SubMerkVehicle::factory()->create();
        $electricCurrent = ElectricCurrent::factory()->create();

        $response = $this->deleteJson(
            route('api.sub-merk-vehicles.electric-currents.store', [
                $subMerkVehicle,
                $electricCurrent,
            ])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $subMerkVehicle
                ->electricCurrents()
                ->where('electric_currents.id', $electricCurrent->id)
                ->exists()
        );
    }
}

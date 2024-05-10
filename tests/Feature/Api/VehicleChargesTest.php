<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Charge;
use App\Models\Vehicle;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VehicleChargesTest extends TestCase
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
    public function it_gets_vehicle_charges(): void
    {
        $vehicle = Vehicle::factory()->create();
        $charges = Charge::factory()
            ->count(2)
            ->create([
                'vehicle_id' => $vehicle->id,
            ]);

        $response = $this->getJson(
            route('api.vehicles.charges.index', $vehicle)
        );

        $response->assertOk()->assertSee($charges[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_vehicle_charges(): void
    {
        $vehicle = Vehicle::factory()->create();
        $data = Charge::factory()
            ->make([
                'vehicle_id' => $vehicle->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.vehicles.charges.store', $vehicle),
            $data
        );

        $this->assertDatabaseHas('charges', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $charge = Charge::latest('id')->first();

        $this->assertEquals($vehicle->id, $charge->vehicle_id);
    }
}

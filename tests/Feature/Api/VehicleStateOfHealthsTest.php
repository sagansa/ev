<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\StateOfHealth;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VehicleStateOfHealthsTest extends TestCase
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
    public function it_gets_vehicle_state_of_healths(): void
    {
        $vehicle = Vehicle::factory()->create();
        $stateOfHealths = StateOfHealth::factory()
            ->count(2)
            ->create([
                'vehicle_id' => $vehicle->id,
            ]);

        $response = $this->getJson(
            route('api.vehicles.state-of-healths.index', $vehicle)
        );

        $response->assertOk()->assertSee($stateOfHealths[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_vehicle_state_of_healths(): void
    {
        $vehicle = Vehicle::factory()->create();
        $data = StateOfHealth::factory()
            ->make([
                'vehicle_id' => $vehicle->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.vehicles.state-of-healths.store', $vehicle),
            $data
        );

        $this->assertDatabaseHas('state_of_healths', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $stateOfHealth = StateOfHealth::latest('id')->first();

        $this->assertEquals($vehicle->id, $stateOfHealth->vehicle_id);
    }
}

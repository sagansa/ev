<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\StateOfHealth;

use App\Models\Vehicle;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StateOfHealthTest extends TestCase
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
    public function it_gets_state_of_healths_list(): void
    {
        $stateOfHealths = StateOfHealth::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.state-of-healths.index'));

        $response->assertOk()->assertSee($stateOfHealths[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_state_of_health(): void
    {
        $data = StateOfHealth::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.state-of-healths.store'), $data);

        $this->assertDatabaseHas('state_of_healths', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_state_of_health(): void
    {
        $stateOfHealth = StateOfHealth::factory()->create();

        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create();

        $data = [
            'km' => $this->faker->randomNumber(5),
            'percentage' => $this->faker->randomNumber(1),
            'how_to_charge' => $this->faker->text(),
            'status' => 'not verified',
            'user_id' => $this->faker->uuid(),
            'user_id' => $user->id,
            'vehicle_id' => $vehicle->id,
        ];

        $response = $this->putJson(
            route('api.state-of-healths.update', $stateOfHealth),
            $data
        );

        $data['id'] = $stateOfHealth->id;

        $this->assertDatabaseHas('state_of_healths', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_state_of_health(): void
    {
        $stateOfHealth = StateOfHealth::factory()->create();

        $response = $this->deleteJson(
            route('api.state-of-healths.destroy', $stateOfHealth)
        );

        $this->assertModelMissing($stateOfHealth);

        $response->assertNoContent();
    }
}

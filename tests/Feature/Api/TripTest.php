<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Trip;

use App\Models\Vehicle;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TripTest extends TestCase
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
    public function it_gets_trips_list(): void
    {
        $trips = Trip::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.trips.index'));

        $response->assertOk()->assertSee($trips[0]->from);
    }

    /**
     * @test
     */
    public function it_stores_the_trip(): void
    {
        $data = Trip::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.trips.store'), $data);

        $this->assertDatabaseHas('trips', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_trip(): void
    {
        $trip = Trip::factory()->create();

        $vehicle = Vehicle::factory()->create();
        $user = User::factory()->create();

        $data = [
            'user_id' => $this->faker->uuid(),
            'from' => $this->faker->text(255),
            'coordinate_from' => $this->faker->text(255),
            'to' => $this->faker->text(255),
            'coordinate_to' => $this->faker->text(255),
            'vehicle_id' => $vehicle->id,
            'user_id' => $user->id,
        ];

        $response = $this->putJson(route('api.trips.update', $trip), $data);

        $data['id'] = $trip->id;

        $this->assertDatabaseHas('trips', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_trip(): void
    {
        $trip = Trip::factory()->create();

        $response = $this->deleteJson(route('api.trips.destroy', $trip));

        $this->assertModelMissing($trip);

        $response->assertNoContent();
    }
}

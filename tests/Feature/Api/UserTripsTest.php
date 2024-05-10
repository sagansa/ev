<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Trip;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTripsTest extends TestCase
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
    public function it_gets_user_trips(): void
    {
        $user = User::factory()->create();
        $trips = Trip::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.trips.index', $user));

        $response->assertOk()->assertSee($trips[0]->from);
    }

    /**
     * @test
     */
    public function it_stores_the_user_trips(): void
    {
        $user = User::factory()->create();
        $data = Trip::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.trips.store', $user),
            $data
        );

        $this->assertDatabaseHas('trips', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $trip = Trip::latest('id')->first();

        $this->assertEquals($user->id, $trip->user_id);
    }
}

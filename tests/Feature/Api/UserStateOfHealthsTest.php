<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\StateOfHealth;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserStateOfHealthsTest extends TestCase
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
    public function it_gets_user_state_of_healths(): void
    {
        $user = User::factory()->create();
        $stateOfHealths = StateOfHealth::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.state-of-healths.index', $user)
        );

        $response->assertOk()->assertSee($stateOfHealths[0]->image);
    }

    /**
     * @test
     */
    public function it_stores_the_user_state_of_healths(): void
    {
        $user = User::factory()->create();
        $data = StateOfHealth::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.state-of-healths.store', $user),
            $data
        );

        $this->assertDatabaseHas('state_of_healths', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $stateOfHealth = StateOfHealth::latest('id')->first();

        $this->assertEquals($user->id, $stateOfHealth->user_id);
    }
}

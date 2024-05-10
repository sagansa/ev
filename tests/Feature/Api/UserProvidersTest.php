<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Provider;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserProvidersTest extends TestCase
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
    public function it_gets_user_providers(): void
    {
        $user = User::factory()->create();
        $providers = Provider::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.providers.index', $user));

        $response->assertOk()->assertSee($providers[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_user_providers(): void
    {
        $user = User::factory()->create();
        $data = Provider::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.providers.store', $user),
            $data
        );

        $this->assertDatabaseHas('providers', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $provider = Provider::latest('id')->first();

        $this->assertEquals($user->id, $provider->user_id);
    }
}

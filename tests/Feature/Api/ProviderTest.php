<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Provider;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProviderTest extends TestCase
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
    public function it_gets_providers_list(): void
    {
        $providers = Provider::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.providers.index'));

        $response->assertOk()->assertSee($providers[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_provider(): void
    {
        $data = Provider::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.providers.store'), $data);

        $this->assertDatabaseHas('providers', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_provider(): void
    {
        $provider = Provider::factory()->create();

        $user = User::factory()->create();

        $data = [
            'name' => $this->faker->unique->text(20),
            'status' => 'not verified',
            'user_id' => $this->faker->uuid(),
            'user_id' => $user->id,
        ];

        $response = $this->putJson(
            route('api.providers.update', $provider),
            $data
        );

        $data['id'] = $provider->id;

        $this->assertDatabaseHas('providers', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_provider(): void
    {
        $provider = Provider::factory()->create();

        $response = $this->deleteJson(
            route('api.providers.destroy', $provider)
        );

        $this->assertModelMissing($provider);

        $response->assertNoContent();
    }
}

<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Provider;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProviderControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_providers(): void
    {
        $providers = Provider::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('providers.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.providers.index')
            ->assertViewHas('providers');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_provider(): void
    {
        $response = $this->get(route('providers.create'));

        $response->assertOk()->assertViewIs('app.providers.create');
    }

    /**
     * @test
     */
    public function it_stores_the_provider(): void
    {
        $data = Provider::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('providers.store'), $data);

        $this->assertDatabaseHas('providers', $data);

        $provider = Provider::latest('id')->first();

        $response->assertRedirect(route('providers.edit', $provider));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_provider(): void
    {
        $provider = Provider::factory()->create();

        $response = $this->get(route('providers.show', $provider));

        $response
            ->assertOk()
            ->assertViewIs('app.providers.show')
            ->assertViewHas('provider');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_provider(): void
    {
        $provider = Provider::factory()->create();

        $response = $this->get(route('providers.edit', $provider));

        $response
            ->assertOk()
            ->assertViewIs('app.providers.edit')
            ->assertViewHas('provider');
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
            'user_id' => $user->id,
        ];

        $response = $this->put(route('providers.update', $provider), $data);

        $data['id'] = $provider->id;

        $this->assertDatabaseHas('providers', $data);

        $response->assertRedirect(route('providers.edit', $provider));
    }

    /**
     * @test
     */
    public function it_deletes_the_provider(): void
    {
        $provider = Provider::factory()->create();

        $response = $this->delete(route('providers.destroy', $provider));

        $response->assertRedirect(route('providers.index'));

        $this->assertModelMissing($provider);
    }
}

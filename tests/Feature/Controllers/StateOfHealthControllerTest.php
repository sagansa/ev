<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\StateOfHealth;

use App\Models\Vehicle;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StateOfHealthControllerTest extends TestCase
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
    public function it_displays_index_view_with_state_of_healths(): void
    {
        $stateOfHealths = StateOfHealth::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('state-of-healths.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.state_of_healths.index')
            ->assertViewHas('stateOfHealths');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_state_of_health(): void
    {
        $response = $this->get(route('state-of-healths.create'));

        $response->assertOk()->assertViewIs('app.state_of_healths.create');
    }

    /**
     * @test
     */
    public function it_stores_the_state_of_health(): void
    {
        $data = StateOfHealth::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('state-of-healths.store'), $data);

        $this->assertDatabaseHas('state_of_healths', $data);

        $stateOfHealth = StateOfHealth::latest('id')->first();

        $response->assertRedirect(
            route('state-of-healths.edit', $stateOfHealth)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_state_of_health(): void
    {
        $stateOfHealth = StateOfHealth::factory()->create();

        $response = $this->get(route('state-of-healths.show', $stateOfHealth));

        $response
            ->assertOk()
            ->assertViewIs('app.state_of_healths.show')
            ->assertViewHas('stateOfHealth');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_state_of_health(): void
    {
        $stateOfHealth = StateOfHealth::factory()->create();

        $response = $this->get(route('state-of-healths.edit', $stateOfHealth));

        $response
            ->assertOk()
            ->assertViewIs('app.state_of_healths.edit')
            ->assertViewHas('stateOfHealth');
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
            'user_id' => $user->id,
            'vehicle_id' => $vehicle->id,
        ];

        $response = $this->put(
            route('state-of-healths.update', $stateOfHealth),
            $data
        );

        $data['id'] = $stateOfHealth->id;

        $this->assertDatabaseHas('state_of_healths', $data);

        $response->assertRedirect(
            route('state-of-healths.edit', $stateOfHealth)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_state_of_health(): void
    {
        $stateOfHealth = StateOfHealth::factory()->create();

        $response = $this->delete(
            route('state-of-healths.destroy', $stateOfHealth)
        );

        $response->assertRedirect(route('state-of-healths.index'));

        $this->assertModelMissing($stateOfHealth);
    }
}

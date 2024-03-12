<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Trip;

use App\Models\Vehicle;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TripControllerTest extends TestCase
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
    public function it_displays_index_view_with_trips(): void
    {
        $trips = Trip::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('trips.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.trips.index')
            ->assertViewHas('trips');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_trip(): void
    {
        $response = $this->get(route('trips.create'));

        $response->assertOk()->assertViewIs('app.trips.create');
    }

    /**
     * @test
     */
    public function it_stores_the_trip(): void
    {
        $data = Trip::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('trips.store'), $data);

        $this->assertDatabaseHas('trips', $data);

        $trip = Trip::latest('id')->first();

        $response->assertRedirect(route('trips.edit', $trip));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_trip(): void
    {
        $trip = Trip::factory()->create();

        $response = $this->get(route('trips.show', $trip));

        $response
            ->assertOk()
            ->assertViewIs('app.trips.show')
            ->assertViewHas('trip');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_trip(): void
    {
        $trip = Trip::factory()->create();

        $response = $this->get(route('trips.edit', $trip));

        $response
            ->assertOk()
            ->assertViewIs('app.trips.edit')
            ->assertViewHas('trip');
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
            'from' => $this->faker->text(255),
            'coordinate_from' => $this->faker->text(255),
            'to' => $this->faker->text(255),
            'coordinate_to' => $this->faker->text(255),
            'vehicle_id' => $vehicle->id,
            'user_id' => $user->id,
        ];

        $response = $this->put(route('trips.update', $trip), $data);

        $data['id'] = $trip->id;

        $this->assertDatabaseHas('trips', $data);

        $response->assertRedirect(route('trips.edit', $trip));
    }

    /**
     * @test
     */
    public function it_deletes_the_trip(): void
    {
        $trip = Trip::factory()->create();

        $response = $this->delete(route('trips.destroy', $trip));

        $response->assertRedirect(route('trips.index'));

        $this->assertModelMissing($trip);
    }
}

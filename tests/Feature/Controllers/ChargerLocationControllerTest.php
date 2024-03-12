<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ChargerLocation;

use App\Models\City;
use App\Models\Provider;
use App\Models\Province;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChargerLocationControllerTest extends TestCase
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
    public function it_displays_index_view_with_charger_locations(): void
    {
        $chargerLocations = ChargerLocation::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('charger-locations.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.charger_locations.index')
            ->assertViewHas('chargerLocations');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_charger_location(): void
    {
        $response = $this->get(route('charger-locations.create'));

        $response->assertOk()->assertViewIs('app.charger_locations.create');
    }

    /**
     * @test
     */
    public function it_stores_the_charger_location(): void
    {
        $data = ChargerLocation::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('charger-locations.store'), $data);

        $this->assertDatabaseHas('charger_locations', $data);

        $chargerLocation = ChargerLocation::latest('id')->first();

        $response->assertRedirect(
            route('charger-locations.edit', $chargerLocation)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_charger_location(): void
    {
        $chargerLocation = ChargerLocation::factory()->create();

        $response = $this->get(
            route('charger-locations.show', $chargerLocation)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.charger_locations.show')
            ->assertViewHas('chargerLocation');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_charger_location(): void
    {
        $chargerLocation = ChargerLocation::factory()->create();

        $response = $this->get(
            route('charger-locations.edit', $chargerLocation)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.charger_locations.edit')
            ->assertViewHas('chargerLocation');
    }

    /**
     * @test
     */
    public function it_updates_the_charger_location(): void
    {
        $chargerLocation = ChargerLocation::factory()->create();

        $provider = Provider::factory()->create();
        $user = User::factory()->create();
        $city = City::factory()->create();
        $province = Province::factory()->create();

        $data = [
            'name' => $this->faker->name(),
            'provider_id' => $this->faker->uuid(),
            'location_on' => 'public',
            'status' => 'not verified',
            'description' => $this->faker->sentence(15),
            'maps' => $this->faker->text(255),
            'system' => 'free',
            'parking' => 'yes',
            'coordinate' => $this->faker->text(100),
            'provider_id' => $provider->id,
            'user_id' => $user->id,
            'city_id' => $city->id,
            'province_id' => $province->id,
        ];

        $response = $this->put(
            route('charger-locations.update', $chargerLocation),
            $data
        );

        $data['id'] = $chargerLocation->id;

        $this->assertDatabaseHas('charger_locations', $data);

        $response->assertRedirect(
            route('charger-locations.edit', $chargerLocation)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_charger_location(): void
    {
        $chargerLocation = ChargerLocation::factory()->create();

        $response = $this->delete(
            route('charger-locations.destroy', $chargerLocation)
        );

        $response->assertRedirect(route('charger-locations.index'));

        $this->assertModelMissing($chargerLocation);
    }
}

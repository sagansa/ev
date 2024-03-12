<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Charger;

use App\Models\ChargerType;
use App\Models\ChargerLocation;
use App\Models\ElectricCurrent;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChargerControllerTest extends TestCase
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
    public function it_displays_index_view_with_chargers(): void
    {
        $chargers = Charger::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('chargers.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.chargers.index')
            ->assertViewHas('chargers');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_charger(): void
    {
        $response = $this->get(route('chargers.create'));

        $response->assertOk()->assertViewIs('app.chargers.create');
    }

    /**
     * @test
     */
    public function it_stores_the_charger(): void
    {
        $data = Charger::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('chargers.store'), $data);

        $this->assertDatabaseHas('chargers', $data);

        $charger = Charger::latest('id')->first();

        $response->assertRedirect(route('chargers.edit', $charger));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_charger(): void
    {
        $charger = Charger::factory()->create();

        $response = $this->get(route('chargers.show', $charger));

        $response
            ->assertOk()
            ->assertViewIs('app.chargers.show')
            ->assertViewHas('charger');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_charger(): void
    {
        $charger = Charger::factory()->create();

        $response = $this->get(route('chargers.edit', $charger));

        $response
            ->assertOk()
            ->assertViewIs('app.chargers.edit')
            ->assertViewHas('charger');
    }

    /**
     * @test
     */
    public function it_updates_the_charger(): void
    {
        $charger = Charger::factory()->create();

        $chargerLocation = ChargerLocation::factory()->create();
        $chargerType = ChargerType::factory()->create();
        $user = User::factory()->create();
        $electricCurrent = ElectricCurrent::factory()->create();

        $data = [
            'charger_location_id' => $this->faker->uuid(),
            'charger_type_id' => $this->faker->randomNumber(),
            'power' => $this->faker->text(10),
            'unit' => $this->faker->numberBetween(0, 127),
            'charge_cost' => $this->faker->randomNumber(0),
            'PPJ' => $this->faker->randomNumber(0),
            'admin_cost' => $this->faker->randomNumber(0),
            'PPN' => 'yes',
            'status' => 'not verified',
            'charger_location_id' => $chargerLocation->id,
            'charger_type_id' => $chargerType->id,
            'user_id' => $user->id,
            'electric_current_id' => $electricCurrent->id,
        ];

        $response = $this->put(route('chargers.update', $charger), $data);

        $data['id'] = $charger->id;

        $this->assertDatabaseHas('chargers', $data);

        $response->assertRedirect(route('chargers.edit', $charger));
    }

    /**
     * @test
     */
    public function it_deletes_the_charger(): void
    {
        $charger = Charger::factory()->create();

        $response = $this->delete(route('chargers.destroy', $charger));

        $response->assertRedirect(route('chargers.index'));

        $this->assertModelMissing($charger);
    }
}

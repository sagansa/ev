<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ChargerType;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChargerTypeControllerTest extends TestCase
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
    public function it_displays_index_view_with_charger_types(): void
    {
        $chargerTypes = ChargerType::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('charger-types.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.charger_types.index')
            ->assertViewHas('chargerTypes');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_charger_type(): void
    {
        $response = $this->get(route('charger-types.create'));

        $response->assertOk()->assertViewIs('app.charger_types.create');
    }

    /**
     * @test
     */
    public function it_stores_the_charger_type(): void
    {
        $data = ChargerType::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('charger-types.store'), $data);

        $this->assertDatabaseHas('charger_types', $data);

        $chargerType = ChargerType::latest('id')->first();

        $response->assertRedirect(route('charger-types.edit', $chargerType));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_charger_type(): void
    {
        $chargerType = ChargerType::factory()->create();

        $response = $this->get(route('charger-types.show', $chargerType));

        $response
            ->assertOk()
            ->assertViewIs('app.charger_types.show')
            ->assertViewHas('chargerType');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_charger_type(): void
    {
        $chargerType = ChargerType::factory()->create();

        $response = $this->get(route('charger-types.edit', $chargerType));

        $response
            ->assertOk()
            ->assertViewIs('app.charger_types.edit')
            ->assertViewHas('chargerType');
    }

    /**
     * @test
     */
    public function it_updates_the_charger_type(): void
    {
        $chargerType = ChargerType::factory()->create();

        $data = [
            'name' => $this->faker->unique->text(10),
        ];

        $response = $this->put(
            route('charger-types.update', $chargerType),
            $data
        );

        $data['id'] = $chargerType->id;

        $this->assertDatabaseHas('charger_types', $data);

        $response->assertRedirect(route('charger-types.edit', $chargerType));
    }

    /**
     * @test
     */
    public function it_deletes_the_charger_type(): void
    {
        $chargerType = ChargerType::factory()->create();

        $response = $this->delete(route('charger-types.destroy', $chargerType));

        $response->assertRedirect(route('charger-types.index'));

        $this->assertModelMissing($chargerType);
    }
}

<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\ElectricCurrent;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ElectricCurrentControllerTest extends TestCase
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
    public function it_displays_index_view_with_electric_currents(): void
    {
        $electricCurrents = ElectricCurrent::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('electric-currents.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.electric_currents.index')
            ->assertViewHas('electricCurrents');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_electric_current(): void
    {
        $response = $this->get(route('electric-currents.create'));

        $response->assertOk()->assertViewIs('app.electric_currents.create');
    }

    /**
     * @test
     */
    public function it_stores_the_electric_current(): void
    {
        $data = ElectricCurrent::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('electric-currents.store'), $data);

        $this->assertDatabaseHas('electric_currents', $data);

        $electricCurrent = ElectricCurrent::latest('id')->first();

        $response->assertRedirect(
            route('electric-currents.edit', $electricCurrent)
        );
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_electric_current(): void
    {
        $electricCurrent = ElectricCurrent::factory()->create();

        $response = $this->get(
            route('electric-currents.show', $electricCurrent)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.electric_currents.show')
            ->assertViewHas('electricCurrent');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_electric_current(): void
    {
        $electricCurrent = ElectricCurrent::factory()->create();

        $response = $this->get(
            route('electric-currents.edit', $electricCurrent)
        );

        $response
            ->assertOk()
            ->assertViewIs('app.electric_currents.edit')
            ->assertViewHas('electricCurrent');
    }

    /**
     * @test
     */
    public function it_updates_the_electric_current(): void
    {
        $electricCurrent = ElectricCurrent::factory()->create();

        $data = [
            'name' => 'AC',
        ];

        $response = $this->put(
            route('electric-currents.update', $electricCurrent),
            $data
        );

        $data['id'] = $electricCurrent->id;

        $this->assertDatabaseHas('electric_currents', $data);

        $response->assertRedirect(
            route('electric-currents.edit', $electricCurrent)
        );
    }

    /**
     * @test
     */
    public function it_deletes_the_electric_current(): void
    {
        $electricCurrent = ElectricCurrent::factory()->create();

        $response = $this->delete(
            route('electric-currents.destroy', $electricCurrent)
        );

        $response->assertRedirect(route('electric-currents.index'));

        $this->assertModelMissing($electricCurrent);
    }
}

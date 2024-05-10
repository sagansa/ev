<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ElectricCurrent;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ElectricCurrentTest extends TestCase
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
    public function it_gets_electric_currents_list(): void
    {
        $electricCurrents = ElectricCurrent::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.electric-currents.index'));

        $response->assertOk()->assertSee($electricCurrents[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_electric_current(): void
    {
        $data = ElectricCurrent::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(
            route('api.electric-currents.store'),
            $data
        );

        $this->assertDatabaseHas('electric_currents', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.electric-currents.update', $electricCurrent),
            $data
        );

        $data['id'] = $electricCurrent->id;

        $this->assertDatabaseHas('electric_currents', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_electric_current(): void
    {
        $electricCurrent = ElectricCurrent::factory()->create();

        $response = $this->deleteJson(
            route('api.electric-currents.destroy', $electricCurrent)
        );

        $this->assertModelMissing($electricCurrent);

        $response->assertNoContent();
    }
}

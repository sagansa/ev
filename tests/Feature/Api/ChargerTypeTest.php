<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\ChargerType;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChargerTypeTest extends TestCase
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
    public function it_gets_charger_types_list(): void
    {
        $chargerTypes = ChargerType::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.charger-types.index'));

        $response->assertOk()->assertSee($chargerTypes[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_charger_type(): void
    {
        $data = ChargerType::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.charger-types.store'), $data);

        $this->assertDatabaseHas('charger_types', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.charger-types.update', $chargerType),
            $data
        );

        $data['id'] = $chargerType->id;

        $this->assertDatabaseHas('charger_types', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_charger_type(): void
    {
        $chargerType = ChargerType::factory()->create();

        $response = $this->deleteJson(
            route('api.charger-types.destroy', $chargerType)
        );

        $this->assertModelMissing($chargerType);

        $response->assertNoContent();
    }
}

<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\TypeVehicle;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TypeVehicleTest extends TestCase
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
    public function it_gets_type_vehicles_list(): void
    {
        $typeVehicles = TypeVehicle::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.type-vehicles.index'));

        $response->assertOk()->assertSee($typeVehicles[0]->type);
    }

    /**
     * @test
     */
    public function it_stores_the_type_vehicle(): void
    {
        $data = TypeVehicle::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.type-vehicles.store'), $data);

        $this->assertDatabaseHas('type_vehicles', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_type_vehicle(): void
    {
        $typeVehicle = TypeVehicle::factory()->create();

        $data = [
            'type' => $this->faker->unique->text(20),
        ];

        $response = $this->putJson(
            route('api.type-vehicles.update', $typeVehicle),
            $data
        );

        $data['id'] = $typeVehicle->id;

        $this->assertDatabaseHas('type_vehicles', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_type_vehicle(): void
    {
        $typeVehicle = TypeVehicle::factory()->create();

        $response = $this->deleteJson(
            route('api.type-vehicles.destroy', $typeVehicle)
        );

        $this->assertModelMissing($typeVehicle);

        $response->assertNoContent();
    }
}

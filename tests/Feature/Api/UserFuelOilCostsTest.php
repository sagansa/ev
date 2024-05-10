<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\FuelOilCost;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserFuelOilCostsTest extends TestCase
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
    public function it_gets_user_fuel_oil_costs(): void
    {
        $user = User::factory()->create();
        $fuelOilCosts = FuelOilCost::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(
            route('api.users.fuel-oil-costs.index', $user)
        );

        $response->assertOk()->assertSee($fuelOilCosts[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_user_fuel_oil_costs(): void
    {
        $user = User::factory()->create();
        $data = FuelOilCost::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.fuel-oil-costs.store', $user),
            $data
        );

        $this->assertDatabaseHas('fuel_oil_costs', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $fuelOilCost = FuelOilCost::latest('id')->first();

        $this->assertEquals($user->id, $fuelOilCost->user_id);
    }
}

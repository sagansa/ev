<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Charger;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserChargersTest extends TestCase
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
    public function it_gets_user_chargers(): void
    {
        $user = User::factory()->create();
        $chargers = Charger::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.chargers.index', $user));

        $response->assertOk()->assertSee($chargers[0]->power);
    }

    /**
     * @test
     */
    public function it_stores_the_user_chargers(): void
    {
        $user = User::factory()->create();
        $data = Charger::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.chargers.store', $user),
            $data
        );

        $this->assertDatabaseHas('chargers', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $charger = Charger::latest('id')->first();

        $this->assertEquals($user->id, $charger->user_id);
    }
}

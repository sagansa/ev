<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Charge;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserChargesTest extends TestCase
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
    public function it_gets_user_charges(): void
    {
        $user = User::factory()->create();
        $charges = Charge::factory()
            ->count(2)
            ->create([
                'user_id' => $user->id,
            ]);

        $response = $this->getJson(route('api.users.charges.index', $user));

        $response->assertOk()->assertSee($charges[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_user_charges(): void
    {
        $user = User::factory()->create();
        $data = Charge::factory()
            ->make([
                'user_id' => $user->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.users.charges.store', $user),
            $data
        );

        $this->assertDatabaseHas('charges', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $charge = Charge::latest('id')->first();

        $this->assertEquals($user->id, $charge->user_id);
    }
}

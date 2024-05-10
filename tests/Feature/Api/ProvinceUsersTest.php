<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Province;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProvinceUsersTest extends TestCase
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
    public function it_gets_province_users(): void
    {
        $province = Province::factory()->create();
        $users = User::factory()
            ->count(2)
            ->create([
                'province_id' => $province->id,
            ]);

        $response = $this->getJson(
            route('api.provinces.users.index', $province)
        );

        $response->assertOk()->assertSee($users[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_province_users(): void
    {
        $province = Province::factory()->create();
        $data = User::factory()
            ->make([
                'province_id' => $province->id,
            ])
            ->toArray();
        $data['password'] = \Str::random('8');

        $response = $this->postJson(
            route('api.provinces.users.store', $province),
            $data
        );

        unset($data['password']);
        unset($data['email_verified_at']);
        unset($data['two_factor_confirmed_at']);
        unset($data['current_team_id']);
        unset($data['profile_photo_path']);

        $this->assertDatabaseHas('users', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $user = User::latest('id')->first();

        $this->assertEquals($province->id, $user->province_id);
    }
}

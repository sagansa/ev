<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\City;
use App\Models\Province;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProvinceCitiesTest extends TestCase
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
    public function it_gets_province_cities(): void
    {
        $province = Province::factory()->create();
        $cities = City::factory()
            ->count(2)
            ->create([
                'province_id' => $province->id,
            ]);

        $response = $this->getJson(
            route('api.provinces.cities.index', $province)
        );

        $response->assertOk()->assertSee($cities[0]->city);
    }

    /**
     * @test
     */
    public function it_stores_the_province_cities(): void
    {
        $province = Province::factory()->create();
        $data = City::factory()
            ->make([
                'province_id' => $province->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.provinces.cities.store', $province),
            $data
        );

        $this->assertDatabaseHas('cities', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $city = City::latest('id')->first();

        $this->assertEquals($province->id, $city->province_id);
    }
}

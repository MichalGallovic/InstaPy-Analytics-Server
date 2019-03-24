<?php

namespace Tests\Feature;

use App\Client;
use App\Profile;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateProfileActivitiesTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_create_profile_activities()
    {
        $client = factory(Client::class)->create();
        $profiles = factory(Profile::class, 3)->create();

        $profileActivities = [
            'api_token' => $client->api_token,
            'data' => $profiles->map(function (Profile $profile) {
                return [
                    'profile_name' => $profile->name,
                    'likes' => $this->faker->numberBetween(0, 100),
                    'comments' => $this->faker->numberBetween(0, 100),
                    'follows' => $this->faker->numberBetween(0, 100),
                    'unfollows' => $this->faker->numberBetween(0, 100),
                    'server_calls' => $this->faker->numberBetween(0, 100),
                    'logged_at' => '2019-01-01 00:00:01'
                ];
            })
        ];

        $response = $this->json('POST', '/api/profile/activities', $profileActivities);

        $this->assertTrue($response->getStatusCode() === 200);

        $profiles->each(function (Profile $profile) {
            $this->assertDatabaseHas('profile_activities', [
                'profile_id' => $profile->id
            ]);
        });
    }

    public function test_create_profile_activities_for_missing_profile()
    {
        $client = factory(Client::class)->create();
        // make does not persist
        $profiles = factory(Profile::class, 3)->make();

        $profileActivities = [
            'api_token' => $client->api_token,
            'data' => $profiles->map(function (Profile $profile) {
                return [
                    'profile_name' => $profile->name,
                    'likes' => $this->faker->numberBetween(0, 100),
                    'comments' => $this->faker->numberBetween(0, 100),
                    'follows' => $this->faker->numberBetween(0, 100),
                    'unfollows' => $this->faker->numberBetween(0, 100),
                    'server_calls' => $this->faker->numberBetween(0, 100),
                    'logged_at' => '2019-01-01 00:00:01'
                ];
            })
        ];

        $response = $this->json('POST', '/api/profile/activities', $profileActivities);

        $this->assertTrue($response->getStatusCode() === 404);

        $profiles->each(function (Profile $profile) {
            $this->assertDatabaseMissing('profile_activities', [
                'profile_id' => $profile->id
            ]);
        });
    }
}

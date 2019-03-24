<?php

namespace Tests\Feature;

use App\Client;
use App\Profile;
use App\ProfileActivity;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateProfileActivitiesTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function test_create_many_profile_activities()
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

        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());

        $profiles->each(function (Profile $profile) {
            $this->assertDatabaseHas('profile_activities', [
                'profile_id' => $profile->id
            ]);
        });
    }

    public function test_create_missing_profiles_for_profile_activities()
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

        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());

        $profiles = Profile::all();

        $profiles->each(function (Profile $profile) {
            $this->assertDatabaseHas('profiles', ['id' => $profile->id]);

            $this->assertDatabaseHas('profile_activities', [
                'profile_id' => $profile->id
            ]);
        });
    }

    public function test_do_not_create_duplicate_profile_activities()
    {
        $client = factory(Client::class)->create();
        $profile = factory(Profile::class)->create();

        $profileActivities = [
            'api_token' => $client->api_token,
            'data' => [
                [
                    'profile_name' => $profile->name,
                    'likes' => $this->faker->numberBetween(0, 100),
                    'comments' => $this->faker->numberBetween(0, 100),
                    'follows' => $this->faker->numberBetween(0, 100),
                    'unfollows' => $this->faker->numberBetween(0, 100),
                    'server_calls' => $this->faker->numberBetween(0, 100),
                    'logged_at' => '2019-01-01 00:00:01'
                ]
            ]
        ];

        $response = $this->json('POST', '/api/profile/activities', $profileActivities);

        $this->assertTrue($response->getStatusCode() === JsonResponse::HTTP_CREATED);

        $this->assertDatabaseHas('profile_activities', [
            'profile_id' => $profile->id
        ]);

        $response = $this->json('POST', '/api/profile/activities', $profileActivities);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());

        $this->assertCount(1, ProfileActivity::all());
    }
}

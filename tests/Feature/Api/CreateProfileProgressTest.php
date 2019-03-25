<?php

namespace Tests\Feature\Api;

use App\Client;
use App\Profile;
use App\ProfileProgress;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateProfileProgressTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function test_create_profile_progresses_from_new_profiles()
    {
        $client = factory(Client::class)->create();
        $profile = factory(Profile::class)->make();
        $profileProgresses = factory(ProfileProgress::class, 3)->make();

        $payload = [
            'api_token' => $client->api_token,
            'data' => $profileProgresses
                ->map(function (ProfileProgress $profileProgress) use ($profile) {
                    return $profileProgress->only(['followers', 'following', 'total_posts', 'logged_at']) +
                        ['profile_name' => $profile->name];
                })->toArray()
        ];

        $response = $this->json('POST', '/api/profile/progresses', $payload);

        $response->assertStatus(JsonResponse::HTTP_CREATED);

        $this->assertDatabaseHas('profiles', ['name' => $profile->name]);

        $profileProgresses = ProfileProgress::all();

        $profileProgresses->each(function (ProfileProgress $profileProgress) {
            $this->assertDatabaseHas('profile_progresses', [
                'profile_id' => $profileProgress->profile->id,
                'logged_at' => $profileProgress->logged_at
            ]);
        });
    }

    public function test_do_not_create_duplicate_progresses()
    {
        $client = factory(Client::class)->create();
        $profile = factory(Profile::class)->states('with_profile_progress')->create();

        $payload = [
            'api_token' => $client->api_token,
            'data' => $profile->profileProgresses
                ->map(function (ProfileProgress $profileProgress) {
                    return $profileProgress->only(['followers', 'following', 'total_posts', 'logged_at']) +
                        ['profile_name' => $profileProgress->profile->name];
                })->toArray()
        ];

        $response = $this->json('POST', '/api/profile/progresses', $payload);
        $response->assertStatus(JsonResponse::HTTP_OK);

        $this->assertCount($profile->profileProgresses->count(), ProfileProgress::all());
    }
}

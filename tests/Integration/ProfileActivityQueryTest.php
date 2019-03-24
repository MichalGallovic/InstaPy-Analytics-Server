<?php

namespace Tests\Integration;

use App\Profile;
use App\ProfileActivity;
use App\Queries\ProfileActivityQuery;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileActivityQueryTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithDatabase;

    public function test_create_one_profile_activity()
    {
        $profileActivityQuery = new ProfileActivityQuery(
            new Profile(), new ProfileActivity()
        );

        $profile = factory(Profile::class)->create();

        $profileActivity = [
            'likes' => 1,
            'comments' => 2,
            'follows' => 3,
            'unfollows' => 4,
            'server_calls' => 5,
            'logged_at' => '2019-01-01 00:00:01'
        ];

        $profileActivityQuery->create($profile->name, $profileActivity);

        $this->assertDatabaseHas('profile_activities', [
            'profile_id' => $profile->id
        ]);
    }

    public function test_create_many_profile_activities()
    {
        $profileActivityQuery = new ProfileActivityQuery(
            new Profile(), new ProfileActivity()
        );

        $profiles = factory(Profile::class, 3)->create();

        $profileActivities = $profiles->map(function (Profile $profile) {
            return [
                'profile_name' => $profile->name,
                'likes' => 1,
                'comments' => 2,
                'follows' => 3,
                'unfollows' => 4,
                'server_calls' => 5,
                'logged_at' => '2019-01-01 00:00:01'
            ];
        })->toArray();

        $profileActivityQuery->createMany($profileActivities);

        $profiles->each(function(Profile $profile) {
            $this->assertDatabaseHas('profile_activities', [
                'profile_id' => $profile->id
            ]);
        });
    }
}

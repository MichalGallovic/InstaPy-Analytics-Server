<?php

namespace App\Queries;

use App\Profile;
use App\ProfileActivity;

class ProfileActivityQuery
{
    /** @var Profile */
    private $profile;

    /** @var ProfileActivity */
    private $profileActivity;

    /**
     * @param Profile         $profile
     * @param ProfileActivity $profileActivity
     */
    public function __construct(Profile $profile, ProfileActivity $profileActivity)
    {
        $this->profile         = $profile;
        $this->profileActivity = $profileActivity;
    }

    /**
     * @param string $profileName
     * @param array  $profileActivity
     *
     * @return null
     */
    public function create(string $profileName, array $profileActivity)
    {
        $profile = $this->profile->where('name', $profileName)->firstOrFail();

        $profileActivity = new ProfileActivity([
            'likes'        => $profileActivity['likes'],
            'comments'     => $profileActivity['comments'],
            'follows'      => $profileActivity['follows'],
            'unfollows'    => $profileActivity['unfollows'],
            'server_calls' => $profileActivity['server_calls'],
            'logged_at'    => $profileActivity['logged_at'],
        ]);

        $profile->profileActivity()->save($profileActivity);
    }

    /**
     * @param array $profileActivities
     */
    public function createMany(array $profileActivities)
    {
        foreach ($profileActivities as $profileActivity) {
            $this->create($profileActivity['profile_name'], $profileActivity);
        }
    }
}

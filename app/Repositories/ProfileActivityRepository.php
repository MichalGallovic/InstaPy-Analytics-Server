<?php

namespace App\Repositories;

use App\Profile;
use App\ProfileActivity;

class ProfileActivityRepository
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
        $profile = $this->profile->where('name', $profileName)
            ->firstOrCreate(['name' => $profileName]);

        $hasActivity = $profile->profileActivity()
            ->where('logged_at', $profileActivity['logged_at'])
            ->count();

        if ($hasActivity > 0) {
            return null;
        }

        $profileActivity = new ProfileActivity([
            'likes'        => $profileActivity['likes'],
            'comments'     => $profileActivity['comments'],
            'follows'      => $profileActivity['follows'],
            'unfollows'    => $profileActivity['unfollows'],
            'server_calls' => $profileActivity['server_calls'],
            'logged_at'    => $profileActivity['logged_at'],
        ]);

        return $profile->profileActivity()->save($profileActivity);
    }

    /**
     * @param array $profileActivities
     *
     * @return \Illuminate\Support\Collection
     */
    public function createMany(array $profileActivities)
    {
        return collect($profileActivities)
            ->map(function ($profileActivity) {
                return $this->create($profileActivity['profile_name'], $profileActivity);
            })
            ->filter(function ($profileActivity) {
                return !is_null($profileActivity);
            });
    }
}

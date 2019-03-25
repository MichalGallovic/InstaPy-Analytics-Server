<?php

namespace App\Repositories;

use App\Profile;
use App\ProfileProgress;

class ProfileProgressRepository
{
    /** @var Profile */
    private $profile;

    /** @var ProfileProgress */
    private $profileProgress;

    /**
     * @param Profile         $profile
     * @param ProfileProgress $profileProgress
     */
    public function __construct(Profile $profile, ProfileProgress $profileProgress)
    {
        $this->profile         = $profile;
        $this->profileProgress = $profileProgress;
    }

    /**
     * @param string $profileName
     * @param array  $profileProgress
     *
     * @return null|ProfileProgress
     */
    public function create(string $profileName, array $profileProgress)
    {
        $profile = $this->profile->where('name', $profileName)
            ->firstOrCreate(['name' => $profileName]);

        $hasProgress = $profile->profileProgresses()
            ->where('logged_at', $profileProgress['logged_at'])
            ->count();

        if ($hasProgress > 0) {
            return null;
        }

        $profileProgress = new ProfileProgress([
            'followers' => $profileProgress['followers'],
            'following' => $profileProgress['following'],
            'total_posts' => $profileProgress['total_posts'],
            'logged_at' => $profileProgress['logged_at']
        ]);

        return $profile->profileProgresses()->save($profileProgress);
    }

    /**
     * @param array $profileProgresses
     *
     * @return \Illuminate\Support\Collection
     */
    public function createMany(array $profileProgresses)
    {
        return collect($profileProgresses)
            ->map(function ($profileProgress) {
                return $this->create($profileProgress['profile_name'], $profileProgress);
            })
            ->filter(function ($profileProgress) {
                return !is_null($profileProgress);
            });
    }
}

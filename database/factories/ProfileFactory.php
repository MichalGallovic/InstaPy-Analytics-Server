<?php

use Faker\Generator as Faker;

$factory->define(\App\Profile::class, function (Faker $faker) {
    return [
        'name' => $faker->userName
    ];
});

$factory->state(\App\Profile::class, 'with_profile_progress', function () {
    return [];
});

$factory->afterCreatingState(\App\Profile::class, 'with_profile_progress', function ($profile) {
    $profile->profileProgresses()->saveMany(
        factory(\App\ProfileProgress::class, 5)->make()
    );
});

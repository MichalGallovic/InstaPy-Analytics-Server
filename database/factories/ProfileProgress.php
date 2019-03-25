<?php

use Faker\Generator as Faker;

$factory->define(\App\ProfileProgress::class, function (Faker $faker) {
    return [
        'followers' => $faker->numberBetween(10, 20),
        'following' => $faker->numberBetween(10, 20),
        'total_posts' => $faker->numberBetween(10, 100),
        'logged_at' => now()->format('Y-m-d H:i:s')
    ];
});

<?php

use Faker\Generator as Faker;

$factory->define(\App\Profile::class, function (Faker $faker) {
    return [
        'name' => $faker->userName
    ];
});

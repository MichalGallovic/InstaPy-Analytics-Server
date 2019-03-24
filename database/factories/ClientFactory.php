<?php

use Faker\Generator as Faker;

$factory->define(\App\Client::class, function (Faker $faker) {
    return [
        'name' => $faker->userName,
        'api_token' => \App\Client\Token::generateToken()
    ];
});

<?php

use Faker\Generator as Faker;

$factory->define(App\Article::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'content' => $faker->unique()->safeEmail,
        'remember_token' => str_random(10),
    ];
});

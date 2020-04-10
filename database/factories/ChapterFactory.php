<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Entities\Chapter::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'order' => $faker->numberBetween(0,100),
        'url' => $faker->url,
        'season_id' => \App\Helper::random_or_create(\App\Entities\Season::class)->id
    ];
});

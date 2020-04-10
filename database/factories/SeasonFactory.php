<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Entities\Season::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'order' => $faker->numberBetween(0,100),
        'serie_id' => \App\Helper::random_or_create(\App\Entities\Serie::class)->id
    ];
});

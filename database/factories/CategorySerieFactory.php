<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Entities\CategorySerie::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'order' => $faker->numberBetween(0,100)
    ];
});

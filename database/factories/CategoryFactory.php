<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Entities\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'order' => $faker->numberBetween(0,100)
    ];
});

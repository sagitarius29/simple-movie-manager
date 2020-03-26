<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Entities\Movie::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'cover' => $faker->imageUrl()
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Holiday;
use Faker\Generator as Faker;

$factory->define(Holiday::class, function (Faker $faker) {
    return [
        'registered_person' => $faker->name,
        'updater' => $faker->name
    ];
});

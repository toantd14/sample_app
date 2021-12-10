<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\UseTerm;
use Faker\Generator as Faker;

$factory->define(UseTerm::class, function (Faker $faker) {
    return [
        'serial_no' => $faker->numberBetween(1, 99999),
        'use_terms' => $faker->text,
        'registered_person' => $faker->name,
        'updater' => $faker->name,
    ];
});

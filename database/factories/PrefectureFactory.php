<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Prefecture;
use Faker\Generator as Faker;

$factory->define(Prefecture::class, function (Faker $faker) {
    return [
        'registered_person'  => $faker->name,
        'updater' =>  $faker->name,
    ];
});

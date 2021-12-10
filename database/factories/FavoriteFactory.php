<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Favorite;
use Faker\Generator as Faker;

$factory->define(Favorite::class, function (Faker $faker) {
    return [
        'receipt_number' => 1,
        'user_cd' => 20201211,
        'del_flg' => $faker->numberBetween(0, 1),
        'registered_person' => $faker->name,
        'updater' => $faker->name
    ];
});

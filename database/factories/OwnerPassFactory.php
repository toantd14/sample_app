<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OwnerPass;
use Faker\Generator as Faker;

$factory->define(OwnerPass::class, function (Faker $faker) {
    return [
        'member_cd' => $faker->numberBetween(1, 1000),
        'pass' => '12345678',
        'registered_person' => $faker->name,
        'updater' => $faker->name,
    ];
});

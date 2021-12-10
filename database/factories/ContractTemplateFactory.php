<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ContractTemplate;
use Faker\Generator as Faker;

$factory->define(ContractTemplate::class, function (Faker $faker) {
    return [
        'serial_no' => $faker->numberBetween(1000000, 9999999),
        'use_terms' => $faker->text(50),
        'del_flg' => $faker->numberBetween(0, 1),
        'registered_person' => $faker->name,
        'updater' => $faker->name
    ];
});

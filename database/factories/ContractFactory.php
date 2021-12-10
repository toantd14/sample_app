<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Contract;
use Faker\Generator as Faker;

$factory->define(Contract::class, function (Faker $faker) {
    return [
        'serial_no' => $faker->numberBetween(1000000, 9999999),
        'receipt_number' => 1,
        'use_terms' => $faker->text(50),
        'zip_cd' => 2020121,
        'prefectures_cd' => $faker->numberBetween(0, 99),
        'municipality_name' => $faker->address,
        'townname_address' => $faker->address,
        'building_name' => $faker->address,
        'tel_no' => '0383785517',
        'del_flg' => $faker->numberBetween(0, 1),
        'registered_person' => $faker->name,
        'updater' => $faker->name,
        'contractor_name' => $faker->name,
    ];
});


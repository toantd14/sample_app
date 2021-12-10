<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OwnerBank;
use Faker\Generator as Faker;

$factory->define(OwnerBank::class, function (Faker $faker) {
    return [
        'bank_cd' => $faker->numberBetween(1, 1000),
        'bank_name' => $faker->text(5),
        'branch_cd' => $faker->numberBetween(1, 10000),
        'branch_name' => $faker->text(5),
        'account_type' => $faker->numberBetween(0, 1),
        'account_name' => $faker->bankAccountNumber,
        'account_kana' => $faker->bankAccountNumber,
        'account_no' => $faker->numberBetween(10000000, 99999999),
        'registered_person' => $faker->name,
        'updater' => $faker->name,
    ];
});

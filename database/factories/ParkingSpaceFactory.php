<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ParkingSpace;
use Faker\Generator as Faker;

$factory->define(ParkingSpace::class, function (Faker $faker) {
    return [
        'child_number' => $faker->numberBetween(1, 100),
        'parking_form' => $faker->numberBetween(0, 4),
        'space_symbol' => $faker->text(5),
        'space_no' => $faker->numberBetween(1, 99),
        'kbn_standard' => $faker->numberBetween(0, 1),
        'kbn_3no' => $faker->numberBetween(0, 1),
        'kbn_lightcar' => $faker->numberBetween(0, 1),
        'car_width' => $faker->randomFloat(2, 1, 100),
        'car_length' => $faker->randomFloat(2, 1, 100),
        'car_height' => $faker->randomFloat(2, 1, 100),
        'car_weight' => $faker->randomFloat(2, 1, 100),
        'registered_person' => $faker->name,
        'updater' => $faker->name,
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Review;
use Faker\Generator as Faker;

$factory->define(Review::class, function (Faker $faker) {
    return [
        'receipt_number' => 1,
        'user_cd' => 20201211,
        'comment' => $faker->text,
        'registered_person' => $faker->name,
        'updater' => $faker->name,
        'evaluation_satisfaction' => $faker->randomFloat($nbMaxDecimals = 1, $min = 1.0, $max = 5.0),
        'evaluation_location' => $faker->randomFloat($nbMaxDecimals = 1, $min = 1.0, $max = 5.0),
        'evaluation_ease_stopping' => $faker->randomFloat($nbMaxDecimals = 1, $min = 1.0, $max = 5.0),
        'evaluation_fee' => $faker->randomFloat($nbMaxDecimals = 1, $min = 1.0, $max = 5.0),
        'created_at' => $faker->dateTimeBetween($startDate = '-1 month', $endDate = 'now', $timezone = null)
    ];
});

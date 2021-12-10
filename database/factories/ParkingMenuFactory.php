<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ParkingMenu;
use Faker\Generator as Faker;

$factory->define(ParkingMenu::class, function (Faker $faker) {
    $start_time = $faker->numberBetween(0, 9);
    $end_time = $faker->numberBetween(10, 24);
    return [
        'parking_cd' => $faker->numberBetween(1, 99999),
        'owner_cd' => 2020 . $faker->numberBetween(0, 1) . $faker->numberBetween(10000, 99999),
        'month_flg' => $faker->numberBetween(0, 1),
        'month_price' => $faker->numberBetween(100, 120),
        'minimum_use' => $faker->numberBetween(1, 9),
        'period_flg' => $faker->numberBetween(0, 1),
        'period_week' => 1,
        'period_monday' => $faker->numberBetween(0, 1),
        'period_tuesday' => $faker->numberBetween(0, 1),
        'period_wednesday' => $faker->numberBetween(0, 1),
        'period_thursday' => $faker->numberBetween(0, 1),
        'period_friday' => $faker->numberBetween(0, 1),
        'period_saturday' => $faker->numberBetween(0, 1),
        'period_sunday' => $faker->numberBetween(0, 1),
        'period_holiday' => $faker->numberBetween(0, 1),
        'period_timeflg' => 0,
        'period_fromtime' => 0 . $start_time . ':00',
        'period_totime' => $end_time . ':00',
        'period_dayflg' => 0,
        'period_fromday' => $faker->dateTime()->format('Y/m/d'),
        'period_today' => $faker->dateTime()->format('Y/m/d'),
        'period_price' => $faker->numberBetween(100, 120),
        'day_flg' => $faker->numberBetween(0, 1),
        'day_price' => $faker->numberBetween(100, 120),
        'time_flg' => $faker->numberBetween(0, 1),
        'registered_person' => $faker->name(),
        'updater'=> $faker->name(),
    ];
});

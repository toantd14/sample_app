<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ParkingMenuTime;
use Faker\Generator as Faker;

$autoIncrement = autoIncrement();

$factory->define(ParkingMenuTime::class, function (Faker $faker) use ($autoIncrement) {
    $time = $autoIncrement->current() % 24;
    $endTime = $time + 1;
    $dayType = floor(($autoIncrement->current() % 96) / 24);
    $data = [
        'day_type' => $dayType,
        'from_time' => ($time < 10 ? 0 : '') . $time . ':00', // $faker->time($format = 'H:i', $max = 'now'),
        'to_time' => ($endTime < 10 ? 0 : '') . $endTime . ':00', // $faker->time($format = 'H:i', $max = 'now'),
        'price' => $faker->numberBetween(100, 120),
        'registered_person' => $faker->name(),
        'updater' => $faker->name(),
    ];
    $autoIncrement->next();
    return $data;
});

function autoIncrement()
{
    for ($i = 0; $i < 1000000; $i++) {
        yield $i;
    }
}

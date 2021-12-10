<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Factory;
use App\Models\ParkingLot;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(ParkingLot::class, function (Faker $faker) {
    $fakerNew = Factory::create('ms_MY');
    $fakeJapanLocation = rand(0, 1);
    $start_time = $faker->numberBetween(0, 9);
    $end_time = $faker->numberBetween(10, 24);
    $lu_start_time = max(min($start_time + rand(-2, 2), 9), 0);
    $lu_end_time =  max(min($end_time + rand(-2, 2), 24), 10);
    return [
        'owner_cd' => 2020 . $faker->numberBetween(0, 1) . $faker->numberBetween(10000, 99999),
        'parking_name' => $faker->name(),
        'zip_cd' => $faker->numberBetween(1000000, 1999999),
        'prefectures_cd' => $faker->numberBetween(1, 20),
        'municipality_name' => $faker->address(),
        'townname_address' => $fakerNew->townState(),
        'building_name' => Str::random(10),
        'latitude' => $fakeJapanLocation == 1 ? $faker->randomFloat($nbMaxDecimals = 2, $min = 20.92, $max = 21.12) : $faker->randomFloat($nbMaxDecimals = 2, $min = 35.57, $max = 35.77),
        'longitude' => $fakeJapanLocation == 1 ? $faker->randomFloat($nbMaxDecimals = 2, $min = 105.69, $max = 105.89) : $faker->randomFloat($nbMaxDecimals = 2, $min = 139.67, $max = 139.87),
        'tel_no' => $faker->numerify('##########'),
        'fax_no' => $faker->numerify('##########'),
        'sales_division' => $faker->numberBetween(0, 1),
        'sales_start_time' =>  0 . $start_time . ':00',
        'sales_end_time' => $end_time . ':00',
        'lu_division' => $faker->numberBetween(0, 1),
        'lu_start_time' => 0 . $lu_start_time . ':00',
        'lu_end_time' => $lu_end_time . ':00',
        'warn' => $faker->text,
        'registered_person' => $faker->name(),
        'updater' => $faker->name(),
        're_enter' => $faker->numberBetween(0, 1),
        'local_payoff' => $faker->numberBetween(0, 1),
        'net_payoff' => $faker->numberBetween(0, 1),
        'image1_url' => rand(0, 1) == 1 ? 'images/image1.jpeg' : '',
        'image2_url' => rand(0, 1) == 1 ? 'images/image2.jpeg' : '',
        'image3_url' => rand(0, 1) == 1 ? 'images/image3.jpeg' : '',
        'image4_url' => rand(0, 1) == 1 ? 'images/image4.jpeg' : '',
        'video1_url' => rand(0, 1) == 1 ? 'videos/video1.mp4' : '',
        'video2_url' => rand(0, 1) == 1 ? 'videos/video2.mp4' : '',
        'video3_url' => rand(0, 1) == 1 ? 'videos/video1.mp4' : '',
        'thumbnail_video' => '{"thumbnail1_url":"images\/video2.png","thumbnail2_url":"images\/video1.png","thumbnail3_url":"images\/video2.png","thumbnail4_url":"images\/default.png"}',
        'mgn_flg' => rand(0, 1),
    ];
});

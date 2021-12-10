<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\UseSituation;
use Faker\Generator as Faker;

$factory->define(UseSituation::class, function (Faker $faker) {
    return [
        'user_cd' => 20201211,
        'parking_spacecd' => $faker->numberBetween(1, 10),
        'parking_menucd' => $faker->numberBetween(1, 10),
        'visit_no' => $faker->numberBetween(0, 3),
        'reservation_use_kbn' => rand(0, 1),
        'contract_id' => 1,
        'reservation_day' => $faker->date($format = 'Y/m/d'),
        'use_day' => $faker->date($format = 'Y/m/d'),
        'from_reservation_time' => $faker->time($format = 'h:i'),
        'to_reservation_time' => $faker->time($format = 'h:i'),
        'putin_time' => $faker->time($format = 'h:i'),
        'putout_time' => $faker->time($format = 'h:i'),
        'start_day' => $faker->date($format = 'Y/m/d'),
        'end_day' => $faker->date($format = 'Y/m/d'),
        'period_month' => $faker->numberBetween(1, 9),
        'usetime_from' => $faker->time($format = 'h:i'),
        'usetime_to' => $faker->time($format = 'h:i'),
        'car_type_reservation' => $faker->text(5),
        'car_no_reservation' => $faker->text(5),
        'car_type_performance' => $faker->text(5),
        'car_no_performance' => $faker->text(5),
        'space_symbol' => $faker->text(5),
        'space_no' => $faker->text(5),
        'name_sei' => $faker->firstName,
        'name_mei' => $faker->lastName,
        'name_seikana' => $faker->firstName,
        'name_meikana' => $faker->lastName,
        'company_name' => $faker->company,
        'department' => $faker->text(5),
        'person_man' => $faker->firstName,
        'tel_no' => '0383785517',
        'payment_division_reservation' => 1,
        'payment_division' => rand(0, 2),
        'money_reservation' => $faker->numberBetween(1, 100),
        'conveni' => 1,
        'conveni_paymentno' => $faker->text(5),
        'settlement_id' => $faker->text(5),
        'conveni_day' => $faker->date($format = 'Y/m/d'),
        'parking_fee' => $faker->numberBetween(1, 100),
        'discount_rates' => $faker->numberBetween(1, 100),
        'combined_point' => $faker->numberBetween(1, 100),
        'payment' => $faker->numberBetween(1, 100),
        'grant_points' => $faker->numberBetween(1, 100),
        'payment_day' => $faker->date($format = 'Y/m/d'),
        'registered_person' => $faker->name,
        'updater' => $faker->name,
    ];
});

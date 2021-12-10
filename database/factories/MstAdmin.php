<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\MstAdmin;
use Faker\Generator as Faker;

$factory->define(MstAdmin::class, function (Faker $faker) {
    return [
        'serial_no' => 123456789,
        'name_sei' => $faker->lastName,
        'name_mei' => $faker->firstName,
        'login_mail' => 'admin@gmail.com',
        'passw' => 12345678,
        'registered_person' => $faker->lastName,
        'updater' => $faker->lastName,
    ];
});

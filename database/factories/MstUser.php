<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\MstUser;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(MstUser::class, function (Faker $faker) {
    static $id = 20201210;
    static $email = 0;
    return [
        'user_cd' => $id++,
        'howto_use' => 0,
        'facebook_id' => 'idFacebook',
        'google_id' => 'idGoogle',
        'line_id' => 'idLine',
        'user_kbn' => rand(0, 1),
        'name_sei' => $faker->name,
        'name_mei' => $faker->name,
        'corporate_name' => $faker->name,
        'department' => $faker->company,
        'person_man' => $faker->name,
        'tel_no' => '0399494011',
        'mail_add' => 'test'. $email++ . '@gmail.com',
        'pass_word' => 12345678,
        'zip_cd' => '1000001',
        'prefectures_cd' => $faker->numberBetween(1, 47),
        'municipality_name' => $faker->name,
        'townname_address' => $faker->address,
        'building_name' => $faker->address,
        'token_key' => Str::random(10),
        'certification_cd' => '1875',
        'certification_result' => 1,
        'registered_person' => $faker->name,
        'updater' => $faker->name
    ];
});

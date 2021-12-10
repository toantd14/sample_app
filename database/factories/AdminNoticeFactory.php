<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\AdminNotice;
use Faker\Generator as Faker;

$factory->define(AdminNotice::class, function (Faker $faker) {
    return [
        'notics_title' => $faker->text(100),
        'notics_details' => $faker->text(100),
        'site_url' => $faker->url,
        'registered_person' => $faker->name,
        'updater' => $faker->name,
    ];
});

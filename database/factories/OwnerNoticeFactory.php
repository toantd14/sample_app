<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OwnerNotice;
use Faker\Generator as Faker;

$factory->define(OwnerNotice::class, function (Faker $faker) {
    return [
        'member_cd' => $faker->numberBetween(1, 1000),
        'notics_title' => $faker->text(100),
        'notics_details' => $faker->text(100),
        'site_url' => $faker->domainName,
        'announce_period' => $faker->numberBetween(1, 5),
        'registered_person' => $faker->name,
        'updater' => $faker->name,
        'created_at' => now()->format(config('constants.DATE.FORMAT_YEAR_FIRST')),
    ];
});

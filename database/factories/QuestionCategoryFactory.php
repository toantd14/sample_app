<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\QuestionCategory;
use Faker\Generator as Faker;

$factory->define(QuestionCategory::class, function (Faker $faker) {
    return [
        'category_name' => $faker->name,
        'del_flg' => $faker->randomElement($array = array (0, 1)),
        'registered_person' => $faker->name,
        'updater' => $faker->name,
    ];
});

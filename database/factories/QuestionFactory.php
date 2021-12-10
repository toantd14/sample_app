<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Question;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'category_id' => $faker->numberBetween(1, 1000),
        'title_name' => $faker->name,
        'contents' => $faker->realText($maxNbChars = 200, $indexSize = 2),
        'del_flg' => $faker->randomElement($array = array (0, 1)),
        'registered_person' => $faker->name,
        'updater' => $faker->name,
    ];
});

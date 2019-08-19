<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Setting;
use Faker\Generator as Faker;

$factory->define(Setting::class, function (Faker $faker) {
    return [
        
        'content' => 
        json_encode(
            [
                'name' => $faker->name . ' setting',
                [
                    $faker->word => $faker->words(),
                    $faker->word => $faker->words(),
                    $faker->word => $faker->words()
                ]
            ]
        )

    ];
});

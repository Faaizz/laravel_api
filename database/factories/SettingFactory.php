<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Setting;
use Faker\Generator as Faker;

$factory->define(Setting::class, function (Faker $faker) {
    return [
        
        'name' => $faker->name,
        'content' => 
        json_encode(
            [
                $faker->word => $faker->words(),
                $faker->word => $faker->words(),
                $faker->word => $faker->words()
                
            ]
        )

    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Staff;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

//The source php file is required from "DatabaseSeede.php"
use Storage\Misc\Functions as MiscFunctions;

$factory->define(Staff::class, function (Faker $faker) {
    return [
        'first_name' => $faker-> name,
        'last_name' => $faker->name,
        'email' => $faker->unique()->email,
        'password' => $faker->password,
        'address' => $faker->address,
        'gender'=> MiscFunctions\getGender(),
        'phone_numbers'=> json_encode(
            [
                '+234' . $faker->randomNumber(8),
                '+234' . $faker->randomNumber(8),
                '+234' . $faker->randomNumber(8)
            ]
            ),
        'api_token' => Str::random(60)
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Staff;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

//The source php file is required from "DatabaseSeede.php"
use Storage\Misc\Functions as MiscFunctions;

$factory->define(Staff::class, function (Faker $faker) {

    $gender= MiscFunctions\getGender();

    return [
        'first_name' => $faker->firstName($gender),
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->email,
        'password' => Str::random(20),
        'address' => $faker->address,
        'gender'=> $gender,
        'phone_numbers'=> json_encode(
            [
                $faker->e164PhoneNumber,
                $faker->e164PhoneNumber,
                $faker->e164PhoneNumber
            ]
            ),
        'api_token' => Str::random(60)
    ];
});

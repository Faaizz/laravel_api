<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Customer;
use Faker\Generator as Faker;

//The source php file is required from "DatabaseSeede.php"
use Storage\Misc\Functions as MiscFunctions;

$factory->define(Customer::class, function (Faker $faker) {



    return [
        'first_name'=> $faker->name,
        'last_name'=> $faker->name,
        'email'=> $faker->unique()->safeEmail,
        'password'=> $faker->text(50),
        'address'=> $faker->address,
        'gender'=> MiscFunctions\getGender(),
        'phone_numbers'=> json_encode(
            [
                '+234' . $faker->randomNumber(8),
                '+234' . $faker->randomNumber(8),
                '+234' . $faker->randomNumber(8)
            ]
            )
    ];
});

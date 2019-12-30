<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Customer;
use Faker\Generator as Faker;

//The source php file is required from "DatabaseSeede.php"
use Storage\Misc\Functions as MiscFunctions;

$factory->define(Customer::class, function (Faker $faker) {

    $gender= MiscFunctions\getGender();

    return [
        'first_name'=> $faker->firstName($gender),
        'last_name'=> $faker->lastName,
        'email'=> $faker->unique()->safeEmail,
        'password'=> $faker->text(50),
        'address'=> $faker->address,
        'gender'=> $gender,
        'phone_numbers'=> json_encode(
            [
                $faker->e164PhoneNumber,
                $faker->e164PhoneNumber,
                $faker->e164PhoneNumber
            ]
            )
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Trend;
use Faker\Generator as Faker;

use Storage\Misc\Functions as MiscFunctions;

$factory->define(Trend::class, function (Faker $faker) {

    //"section", "sub_section", and "category" randomization
    $section= MiscFunctions\getSection();
    $gender= MiscFunctions\getTrendGender();

    if($gender == 'unisex'){
        // Get random male or female pictures
        $images= MiscFunctions\getImages($section, MiscFunctions\getGender());
    }
    else{
        $images= MiscFunctions\getImages($section, $gender);
    }
    

    return [
        'name'=> $faker->words(4, true),
        'description'=> $faker->text(100),
        'gender'=> $gender,
        'images'=> $images
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

//The source php file is required from "DatabaseSeede.php"
use Storage\Misc\Functions as MiscFunctions;

$factory->define(Product::class, function (Faker $faker) {

    //"section", "sub_section", and "category" randomization
    $section= MiscFunctions\getSection();
    $sub_section= MiscFunctions\getGender();
    $category= MiscFunctions\getCategory($section, $sub_section);

    return [
        'name'=> $faker->text(75),
        'brand'=> $faker->word,
        'description'=> $faker->text(1000),
        'section'=> $section,
        'sub_section'=> $sub_section,
        'category' => $category,
        'price'=> $faker->randomFloat(2),
        'color'=> $faker->colorName,
        'material'=> $faker->word,
        'images'=> json_encode(
            []
        ),
        'options'=> json_encode(
            []
        )

    ];
});

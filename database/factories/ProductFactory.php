<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

use Storage\Misc\Functions as MiscFunctions;

$factory->define(Product::class, function (Faker $faker) {

    //"section", "sub_section", and "category" randomization
    $section= MiscFunctions\getSection();
    $sub_section= MiscFunctions\getGender();
    $category= MiscFunctions\getCategory($section, $sub_section);
    $images= MiscFunctions\getImages($section, $sub_section);
    $options= MiscFunctions\getOptions($section);

    return [
        'name'=> $faker->words(4, true),
        'brand'=> $faker->company,
        'description'=> $faker->text(100),
        'section'=> $section,
        'sub_section'=> $sub_section,
        'category' => $category,
        'price'=> $faker->randomFloat(2, 2000, 25000),
        'color'=> $faker->colorName,
        'material'=> $faker->word,
        'images'=> $images,
        'options'=> $options

    ];
});

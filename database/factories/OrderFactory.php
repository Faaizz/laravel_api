<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use Faker\Generator as Faker;


$factory->define(Order::class, function (Faker $faker) {

    $productSizes= ['xs', 'sm', 'md', 'lg', 'xl', 'xxl', 'xxxl'];

    return [
        
        'product_id' => rand(1, 300),
        'product_color' => $faker->colorName,
        'product_size' => $productSizes[ rand(0, (count($productSizes) - 1) )],
        'product_quantity' => $faker->randomDigit,
        'customer_id' => rand(1, 50),
        
    ];
});

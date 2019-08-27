<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use App\Customer;
use App\Product;
use Faker\Generator as Faker;


$factory->define(Order::class, function (Faker $faker) {

    $productSizes= ['xs', 'sm', 'md', 'lg', 'xl', 'xxl', 'xxxl'];

    //get all available customers
    $customers= Customer::all();

    //get all available products
    $products= Product::all();

    return [
        
        //select a random product for the order
        'product_id' => $products->random()->id,
        'product_color' => $faker->colorName,
        'product_size' => $productSizes[ rand(0, (count($productSizes) - 1) )],
        'product_quantity' => $faker->randomDigit,
        //select a random customer for the order
        'customer_email' => $customers->random()->email,
        
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use App\Customer;
use App\Product;
use App\Staff;
use Faker\Generator as Faker;


$factory->define(Order::class, function (Faker $faker) {

    $productSizes= ['XS', 'SM', 'MD', 'LG', 'XL'];

    //get all available customers
    $customers= Customer::all();

    //get all available products
    $products= Product::all();

    //get all available staff
    $staffs= Staff::all();

    return [
        
        //select a random product for the order
        'product_id' => $products->random()->id,
        'product_size' => $productSizes[ rand(0, (count($productSizes) - 1) )],
        'product_quantity' => $faker->randomDigit,
        //select a random customer for the order
        'customer_email' => $customers->random()->email,
        //select a random staff for the order
        // 'staff_email' => $staffs->random()->email,
        'status' => 'unassigned'
        
    ];
});

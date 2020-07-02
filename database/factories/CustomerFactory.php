<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Customer;
use App\Product;
use Faker\Generator as Faker;

//The source php file is required from "DatabaseSeede.php"
use Storage\Misc\Functions as MiscFunctions;

$factory->define(Customer::class, function (Faker $faker) {

    $gender= MiscFunctions\getGender();

    // Get 10 random products
    $products= Product::all()->random(10);
    // Liked Items Array
    $liked_items= [];
    // Add products to liked items
    $products->each(function($product, $key) use (&$liked_items){
        
        $new_element= [
            "id"=> $product->id,
            "size"=> \json_decode($product->options)[0]->size
        ];
        array_push($liked_items, $new_element);

    });

    // Get 10 random products
    $products= Product::all()->random(10);
    // Shopping Cart Array
    $shopping_cart= [];
    // Add products to shopping cart
    $products->each(function($product, $key) use (&$shopping_cart){
        
        $new_element= [
            "id"=> $product->id,
            "size"=> \json_decode($product->options)[0]->size,
            "quantity"=> 1
        ];
        array_push($shopping_cart, $new_element);
        
    });

    return [
        'first_name'=> $faker->firstName($gender),
        'last_name'=> $faker->lastName,
        'email'=> $faker->unique()->safeEmail,
        'password'=> Hash::make("Password"),
        'address'=> $faker->address,
        'gender'=> $gender,
        'phone_numbers'=> json_encode(
            [
                $faker->e164PhoneNumber,
                $faker->e164PhoneNumber,
                $faker->e164PhoneNumber
            ]
            ),
        'liked_items'=> \json_encode($liked_items),
        'shopping_cart'=> \json_encode($shopping_cart)
    ];
});

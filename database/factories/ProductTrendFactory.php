<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProductTrend;
use App\Product;
use App\Trend;
use Faker\Generator as Faker;


$factory->define(ProductTrend::class, function (Faker $faker) {

    //get a random product
    $product= Product::all()->random();

    //select a unisex trend or a trend with the same gender
    $trend= Trend::where('gender', $product->sub_section)->orWhere('gender', 'unisex')->get()->random();

    return [
        'product_id' => $product->id,
        'trend_id' => $trend->id
    ];
});

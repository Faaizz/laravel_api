<?php

use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test', function(Request $request){
    //$customer= factory(App\Customer::class)->create();
    //$customer->dd();
    $customers= App\Customer::all();
    $customers->dd();

    //$product= factory(App\Product::class)->create();
    $products= App\Product::all();
    $products->dd();

    //echo MiscFunctions\getSection();
});
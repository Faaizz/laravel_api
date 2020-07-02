<?php

use App\Product;
use App\Trend;

use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// HOMEPAGE
Route::get('/', function(){
    // LOAD 10 TRENDS TO DISPLAY (SHUFFLE)
    $trending= Trend::all()->shuffle();

    return view('home', 
        [
        'page_name'=> 'Home',
        'trending' => $trending
        ]
    );
})->name("home");


/*  P   R   O   D   U   C   T       R   E   L   A   T   E   D */
//ALL
Route::get('/all', function(){

})->name('all');

//MALE
Route::get('/male', 'web\ProductsController@male')->name('male');
Route::get('/male_categories', 'web\ProductsController@maleCategories');
Route::get('/male_sizes', 'web\ProductsController@maleSizes');

//FEMALE
Route::get('/female', 'web\ProductsController@female')->name('female');
Route::get('/female_categories', 'web\ProductsController@femaleCategories');
Route::get('/female_sizes', 'web\ProductsController@femaleSizes');

// SINGLE PRODUCT
Route::get('/products/{id}', 'web\ProductsController@single')->where('id', '[0-9]+');


/*  A   C   C   O   U   N   T       R   E   L   A   T   E   D  */
// AUTHENTICATION
Auth::routes();

//ACCOUNT
Route::middleware('auth')->get('/account', 'web\AccountController@orders')->name('account');
Route::middleware('auth')->get('/details', 'web\AccountController@details')->name('details');
Route::middleware('auth')->post('/details', 'web\AccountController@edit_details')->name('edit_details');
Route::middleware('auth')->get('/password_change', 'web\AccountController@password_change')->name('password_change');
Route::middleware('auth')->post('/password_change', 'web\AccountController@effect_password_change')->name('effect_password_change');
Route::middleware('auth')->get('/logout', 'web\AccountController@logout')->name('logout');

//LIKED ITEMS
Route::middleware('auth')->get('/liked_items', 'web\AccountController@liked_items')->name('liked_items');

//CART
Route::middleware('auth')->get('/shopping_cart', 'web\AccountController@shopping_cart')->name('shopping_cart');


/*  S   E   R   V   I   C   E       R   E   L   A   T   E   D */
//ABOUT US
Route::get('/about_us', function(){
    return view('about_us');
})->name('about_us');

// HELP
Route::get('/help', function(){

})->name('help');

//TERMS AND POLICY
Route::get('/terms', function(){

})->name('terms_and_policy');




// STORAGE FILES
Route::get('/storage/{file_name}', function ($file_name) {
    //return $file_name;
    return Storage::disk('public')->download($file_name);
});


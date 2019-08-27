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

Route::get('test', function(Request $request){
   
    $orders= App\Order::where('product_id', 19)->delete();

    $orders= App\Order::where('product_id', 19)->get();
    
   return response()->json($orders, 200);
});



/**
 *  R   O   O   T
 */
Route::options('/', 'RootController@options')
        ->name('root');


/** =================================================================================================================== */

/**
 *  P   R   O   D   U   C   T       R   O   U   T   E   S
 */



/* O    P   T   I   O   N   S   */
Route::options('/products', 'ProductController@options');


/* R   E   A   D */

//ALL PRODUCTS
Route::get('/products/{section?}/{sub_section?}/{category?}', 'ProductController@index')
        ->where([
            'section' => '[A-Za-z]+',
            'sub_section' => '[A-Za-z]+',
            'category' => '[A-Za-z]+'
        ]);

//NEW IN
Route::get('/products/new_in/{weeeks?}/{section?}/{sub_section?}/{category?}', 'ProductController@new')
        ->where([
            'weeks' => '[0-9]+',
            'section' => '[A-Za-z]+',
            'sub_section' => '[A-Za-z]+',
            'category' => '[A-Za-z]+'
        ]);

//PRODUCT SEARCH
Route::post('/products/search', 'ProductController@search');

//SINGLE PRODUCT SELECT
Route::get('/products/{id}', 'ProductController@show');


/* C    R   E   A   T   E */

//ADD PRODUCT
Route::middleware('auth:api')->post('/products', 'ProductController@store');


/* U    P   D   A   T   E */

//UPDATE PRODUCT
Route::middleware('auth:api')->post('/products/{id}', 'ProductController@update')
        ->where(
            'id', '[0-9]+'
        );


/* D    E   L   E   T   E */

//DELETE SINGLE
Route::middleware('auth:api')->delete('/products/{id}', 'ProductController@delete')
        ->where(
            'id', '[0-9]+'
        );

//DELETE MULTIPLE
Route::middleware('auth:api')->post('/products/mass_delete', 'ProductController@massDelete');



/** =================================================================================================================== */

/**
 *  C  U  S  T  O  M  E  R       R   O   U   T   E   S
 */



/* O    P   T   I   O   N   S   */
Route::options('/customers', 'CustomerController@options');


/* L  O  G  I  N */
Route::middleware('auth:api')->post('/customers/login', 'CustomerController@login');


/* R   E   A   D */

//ALL CUSTOMERS
Route::middleware('auth:api')->get('/customers', 'CustomerController@index');


//SINGLE CUSTOMER
Route::middleware('auth:api')->get('/customers/email/{email}', 'CustomerController@show');

//SINGLE CUSTOMER SELF ACCESS
Route::middleware('auth:api')->get('/customers/my_account', 'CustomerController@self');


/* C  R  E  A  T  E */

//ADD CUSTOMER
Route::middleware('auth:api')->post('/customers', 'CustomerController@store');


/* U  P  D  A  T  E */

//EDIT CUSTOMER
Route::middleware('auth:api')->post('/customers/my_account', 'CustomerController@update');


/* D  E  L  E  T  E */

//DELETE CUSTOMER
Route::middleware('auth:api')->delete('/customers/{email}', 'CustomerController@delete');

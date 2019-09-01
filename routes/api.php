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
 //Method set as ANY so that pagination works well
Route::any('/products/search', 'ProductController@search');

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
 //Cookie Login
 Route::middleware('auth:api')->post('/customers/login', 'CustomerController@cookie_login'); 

 //Manual Login
 Route::middleware('auth:api')->post('/customers/login/manual', 'CustomerController@login')->name('customer_manual_login');

  //Logout
  Route::middleware('auth:api')->get('/customers/logout', 'CustomerController@logout'); 


/* R   E   A   D */

//ALL CUSTOMERS
Route::middleware('auth:api')->get('/customers', 'CustomerController@index');


//SINGLE CUSTOMER
Route::middleware('auth:api')->get('/customers/email/{email}', 'CustomerController@show');

//SINGLE CUSTOMER SELF ACCESS
Route::middleware('auth:api')->get('/customers/my_account', 'CustomerController@self');

 //CUSTOMER SEARCH
 //Method set as ANY so that pagination works well
 Route::any('/customers/search', 'CustomerController@search');


/* C  R  E  A  T  E */

//ADD CUSTOMER
Route::middleware('auth:api')->post('/customers', 'CustomerController@store');


/* U  P  D  A  T  E */

//EDIT CUSTOMER
Route::middleware('auth:api')->post('/customers/my_account', 'CustomerController@update');


/* D  E  L  E  T  E */

//DELETE CUSTOMER
Route::middleware('auth:api')->delete('/customers/{email}', 'CustomerController@delete');



/** =================================================================================================================== */

/**
 *  S  T  A  F  F       R   O   U   T   E   S
 */


 /* O  P  T  I  O  N  S */
 Route::options('/staff', 'StaffController@options');

 /* L  O  G  I  N */
 
 //Cookie Login
 Route::middleware('auth:api')->post('/staff/login', 'StaffController@cookie_login'); 

 //Manual Login
 Route::middleware('auth:api')->post('/staff/login/manual', 'StaffController@login')->name('staff_manual_login');

 //Logout
 Route::middleware('auth:api')->get('/staff/logout', 'StaffController@logout'); 


 /* R  E  A  D */

 //All Staff
 Route::middleware('auth:api')->get('/staff', 'StaffController@index');

 //Single Staff
 Route::middleware('auth:api')->get('/staff/email/{email}', 'StaffController@show');

 //Single Staff Self Access
 Route::middleware('auth:api')->get('/staff/my_account', 'StaffController@self');

 //Staff SEARCH
 //Method set as ANY so that pagination works well
 Route::any('/staff/search', 'StaffController@search');


 /* C  R  E  A  T  E */
 
 //ADD STAFF
 Route::middleware('auth:api')->post('/staff', 'StaffController@store');


 /* U  P  D  A  T  E */
 
 //EDIT STAFF
 Route::middleware('auth:api')->post('/staff/my_account', 'StaffController@update');
 
 /* D  E  L  E  T  E */

//DELETE STAFF
Route::middleware('auth:api')->delete('/staff/{email}', 'StaffController@delete');

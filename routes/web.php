<?php

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

Route::get('/test', function(Request $request){
    
   return response()->json("Hi There", 200);
});


Route::get('/storage/{file_name}', function ($file_name) {
    return Storage::get($file_name);;
});


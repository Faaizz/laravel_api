<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

//import my miscellaneous functions
require_once(storage_path('misc/my_functions.php'));
use Storage\Misc\Functions as MiscFunctions;


class AccountController extends Controller
{
    

    // MY ORDERS
    function orders(){
        
        $orders= Auth::guard("web")->user()->orders;

        return view("orders", ["orders" => $orders]);

    }

    // MY DETAILS
    function details(){
        return view("details");
    }

    // EDIT DETAILS
    function edit_details(Request $request){

        $first_name= $request->input("first_name");
        $last_name= $request->input("last_name");
        $address= $request->input("address");
        $phone_number= $request->input("phone_number");

        if(!(
            ($first_name) ||
            ($last_name) ||
            ($address) ||
            ($phone_number) 
        )){

            // Nothing to update
            session()->put('update', "Nothing to update.");

        }
        else{

            // Perform Update
            if($first_name){
                Auth::guard("web")->user()->first_name= $first_name;
            }

            if($last_name){
                Auth::guard("web")->user()->last_name= $last_name;
            }

            if($address){
                Auth::guard("web")->user()->address= $address;
            }

            if($phone_number){
                Auth::guard("web")->user()->phone_numbers= \json_encode([$phone_number]);
            }

            // Save changes to database
            Auth::guard("web")->user()->save();

            // Successful Update
            session()->put('update', "Details updated successfully.");

        }

        return view("details");

    }

    // PASSWORD CHANGE
    function password_change(){

        return view("password_change");

    }

    function effect_password_change(Request $request){

        //VALIDATION
        $rules= [
            'password' => 'required|max:250|string',
            'new_password' => 'required|max:250|min:8|string|confirmed',
            'new_password_confirmation' => 'required|max:250|string'
        ];

        $request_validator= Validator::make($request->all(), $rules);

        //FAILED LARAVEL REQUEST VALIDATION
        if($request_validator->fails()){

            return view("password_change", ["errors"=> $request_validator->errors()]);

        }

        // IF CURRENT PASSWORD IS INCORRECT
        if( !Hash::check($request->input("password"), Auth::guard("web")->user()->password) ){

            session()->put("password", "Incorrect password");
            return view("password_change");

        }

        // IF PASSWORD IS CORRECT, CHANGE PASSWORD
        Auth::guard("web")->user()->password= Hash::make($request->input("new_password"));
        // Save to database
        Auth::guard("web")->user()->save();

        // Set session to indicate update
        $request->session()->put('update', "Password Changed.");

        return view("password_change");

    }

    // LOGOUT
    function logout(){
        Auth::logout();
        return view("auth.login");
    }


    // LIKED ITEMS
    function liked_items(Request $request){

        // Check if product addition or removal is requested (via query string)
        if($request->input('id') && $request->input('size')){

            // ADDITION
            $product_id= \intval($request->input('id'));
            $product_size= $request->input('size');

            // Remove product from liked_items
            $new_liked_items= MiscFunctions\addProductToList(
                Auth::guard('web')->user()->liked_items, 
                ["id"=> $product_id, "size"=> $product_size]
            );

            // Check for success
            if($new_liked_items != null){

                // Update liked items in database
                Auth::guard('web')->user()->liked_items= $new_liked_items;
                Auth::guard('web')->user()->save();

                // Set session to indicate update
                $request->session()->put('update', "Item added to Liked Items.");

            }       

        }
        // REMOVAL
        else if($request->input('id') && $request->input('remove')){

            $product_id= \intval($request->input('id'));

            // Remove product from liked_items
            $new_liked_items= MiscFunctions\removeProductFromList(Auth::guard('web')->user()->liked_items, $product_id);

            // Check for success
            if($new_liked_items != null){

                // Update liked items in database
                Auth::guard('web')->user()->liked_items= $new_liked_items;
                Auth::guard('web')->user()->save();

                // Set session to indicate update
                $request->session()->put('update', "Item removed.");

            }
            else {
                return response();
                abort(500, "Error Updating Liked Items");
            }

        }


        $liked_items= \json_decode(Auth::guard('web')->user()->liked_items);

        return view('liked_items', ['liked_items'=> $liked_items]);

    }

    
    // SHOPPING CART
    function shopping_cart(Request $request){

        // Check if product addition or removal is requested (via query string)
        if($request->input('id') && $request->input('quantity') && $request->input('size')){

            // ADDITION
            $product_id= \intval($request->input('id'));
            $product_size= $request->input('size');
            $product_quantity= \intval($request->input('quantity'));


            // Add product to shopping_cart
            $new_shopping_cart= MiscFunctions\addProductToList(
                Auth::guard('web')->user()->shopping_cart, 
                ["id"=> $product_id, "size"=> $product_size, "quantity"=> $product_quantity]
            );

            // Check for success
            if($new_shopping_cart != null){

                // Update shopping cart
                Auth::guard('web')->user()->shopping_cart= $new_shopping_cart;

                // If request is from liked items
                if($request->input('liked_items')){
                    // Remove product from liked items
                    $new_liked_items= MiscFunctions\removeProductFromList(Auth::guard('web')->user()->liked_items, $product_id);

                    // Check for success
                    if($new_liked_items != null){

                        // Update liked items
                        Auth::guard('web')->user()->liked_items= $new_liked_items;
                        // Save changes to database
                        Auth::guard('web')->user()->save();

                        // Set session to indicate update
                        $request->session()->put('update', "Item added to Shopping Cart.");
                    }
                    else{
                    return response("Error Updating Liked Items");
                    abort(500, "Error Updating Liked Items");                    
                    }
                }

            }
            else{
               return response("Error Updating Cart");
               abort(500, "Error Updating Cart");                
            }           


        }
        // Check if product quantity has been changed
        else if($request->input('id') && $request->input('quantity')){

            $product_id= \intval($request->input('id'));
            $product_quantity= \intval($request->input('quantity'));

            // Attempt quantity change
            $new_shopping_cart= MiscFunctions\editProductInList(Auth::guard('web')->user()->shopping_cart, $product_id, $product_quantity);

            //Success
            if($new_shopping_cart != null){
                Auth::guard('web')->user()->shopping_cart= $new_shopping_cart;
                Auth::guard('web')->user()->save();
            }
            else{
               abort(500, "Error Editing Quantity in Cart");
            }


        }
        // REMOVAL
        else if($request->input('id') && $request->input('remove')){

            $product_id= \intval($request->input('id'));

            // Remove product from shopping_cart
            $new_shopping_cart= MiscFunctions\removeProductFromList(Auth::guard('web')->user()->shopping_cart, $product_id);

            // Check for success
            if($new_shopping_cart != null){

                // Update shopping cart
                Auth::guard('web')->user()->shopping_cart= $new_shopping_cart;
                // Save changes to database
                Auth::guard('web')->user()->save();

                // Set session to indicate update
                $request->session()->put('update', "Item removed.");

            }
            else{
                abort(500, "Error Updating Cart");
            }

        }

        $cart_items= \json_decode(Auth::guard('web')->user()->shopping_cart);

        return view('shopping_cart', ['cart_items'=> $cart_items]);

    }

}

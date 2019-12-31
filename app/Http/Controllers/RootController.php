<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RootController extends Controller
{
    
    public function options(){

        return response()->json([
            
            'methods' =>    [

                'OPTIONS',
                'GET',
                'POST',
                'DELETE'

            ],
            
            'endpoints' => [

                //PRODUCTS
                [
                    'path' => '/products',
                    'method' => 'OPTIONS',
                    'description' => 'get available information about this resource'
                ],

                //CUSTOMERS
                [
                    'path' => '/customers',
                    'method' => 'OPTIONS',
                    'description' => 'get available information about this resource'
                ],

            ]


        ], 200);

    }

}

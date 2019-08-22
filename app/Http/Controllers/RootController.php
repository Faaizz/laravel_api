<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RootController extends Controller
{
    
    public function options(){

        return response()->json([
            
            'methods' =>    [

                'OPTIONS'

            ],
            
            'endpoints' => [

                [
                    'method' => 'OPTIONS',

                    'args' => [

                        'arg_name' => [

                            'required' => false,
                            'description' => 'Sample template for API documentation structure',
                            'type' => 'string'

                        ]

                    ]
                ]

            ]


        ], 200);

    }

}

<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Staff;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use Utility\SimulateLogin;

class SettingController extends Controller
{

    /**
     * Returns available endpoints and their descriptions and required arguments
     * 
     * @return JSON JSON formatteed response
     * 
     */
    public function options(){

        return response()->json([
            
            'methods' =>    [

                'OPTIONS',
                'GET',
                'POST',
                'PUT',
                'DELETE'

            ],

            'endpoints' => [

                /* O  P  T  I  O  N  S */

                [
                    'path' => '/',
                    'method' => 'OPTIONS',
                    'description' => 'returns available methods',
                    'authentication' => [
                        'api' => 'token'
                    ],
                    'args' => [

                    ],
                    'return_type' => 'json',
                    'return_data_structure' => []
                ],


                /* R  E  A  D */

                //All Settings
                [
                    'path' => '/',
                    'method' => 'GET',
                    'description' => 'Get a listing of all settings',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'admin'
                    ],
                    'args' => [

                    ],
                    'return_type' => 'json',
                    'return_data_structure' => [
                        'failed_authentication' => [
                            'failed_authentication' => 'Please login as an admin'
                        ],
                        'failed_authorization' => [
                            'failed_authentication' => 'Please login as an admin'
                        ],
                        'errors' => [
                            'error' => 'error message'
                        ],
                        'success' => [
                            'data' => [
                                [
                                    'name' => 'string',
                                    'content' => 'json'
                                ]
                            ]
                        ]
                    ]
                ],  

                //Single setting
                [
                    'path' => '/{name}',
                    'method' => 'GET',
                    'description' => 'Pull a single setting',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'admin'
                    ],
                    'args' => [
                        'ROUTE' => [
                            'name' => [
                                'required' => true,
                                'description' => 'Name of setting to pull',
                                'type' => 'string'
                            ]
                        ]
                    ],
                    'return_type' => 'json',
                    'return_data_structure' => [
                        'failed_authentication' => [
                            'failed_authentication' => 'Please login as an admin'
                        ],
                        'failed_authorization' => [
                            'failed_authentication' => 'Please login as an admin'
                        ],
                        'errors' => [
                            'error' => 'error message'
                        ],
                        'success' => [
                            'data' => [
                                'name' => 'string',
                                'content' => 'json'
                            ]
                        ]
                    ]
                ],

                /* C  R  E  A  T  E */
                //Create new setting
                [
                    'path' => '/',
                    'method' => 'POST',
                    'description' => 'Add a new setting',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'admin'
                    ],
                    'args' => [
                        'POST' => [
                            'name' => [
                                'required' => true,
                                'description' => 'Setting name',
                                'type' => 'string'
                            ],
                            'content' => [
                                'required' => true,
                                'description' => 'Setting content',
                                'type' => ''
                            ]
                        ]
                    ],
                    'return_type' => 'json',
                    'return_data_structure' => [
                        'failed_authentication' => [
                            'failed_authentication' => 'Please login as an admin'
                        ],
                        'failed_authorization' => [
                            'failed_authentication' => 'Please login as an admin'
                        ],
                        'failed_validation' => [
                            'field' => 'Validation message'
                        ],
                        'errors' => [
                            'error' => 'error message'
                        ],
                        'success' => [
                            'Empty response with 201 response code'
                        ]
                    ]
                ],

                /* U  P  D  A  T  E */
                //Change the content of a Setting
                [
                    'path' => '/{name}',
                    'description' => 'Change content of a setting',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'admin'
                    ],
                    'args' => [
                        'ROUTE' => [
                            'name' => [
                                'required' => true,
                                'description' => 'Setting name',
                                'type' => 'string'
                            ],
                            'content' => [
                                'required' => true,
                                'description' => 'Setting content',
                                'type' => 'json'
                            ]
                        ]
                    ],
                    'return_type' => 'json',
                    'return_data_structure' => [
                        'failed_authentication' => [
                            'failed_authentication' => 'Please login as an admin'
                        ],
                        'failed_authorization' => [
                            'failed_authentication' => 'Please login as an admin'
                        ],
                        'errors' => [
                            'error' => 'error message'
                        ],
                        'success' => [
                            'message' => 'Success message',
                            'data' => [
                                'name' => 'string',
                                'content' => 'json'
                            ]
                        ]
                    ]
                ],

                /* D  E  L  E  T  E */
                //Delete Setting
                [
                    'path' => '/{name}',
                    'description' => 'Delete setting',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'admin'
                    ],
                    'args' => [
                        
                    ],
                    'return_type' => 'json',
                    'return_data_structure' => [
                        'failed_authentication' => [
                            'failed_authentication' => 'Please login as an admin'
                        ],
                        'failed_authorization' => [
                            'failed_authentication' => 'Please login as an admin'
                        ],
                        'errors' => [
                            'error' => 'error message'
                        ],
                        'success' => [
                            'message' => 'Success message'
                        ]
                    ]
                ]

            ]

        ], 200);

    }


    /* R  E  A  D */
    /**
     * Return a listing of all existing settings
     * 
     * @return JSON JSON formatted Response
     */
    public function index(){

        /**========SIMULATE ADMIN LOGIN=========== */
        SimulateLogin::admin();

        //Validate Authentication
        //If no staff is signed in
        if( !Auth::guard('staffs')->check() ){

            return response()->json( [
                "failed_authentication" => "Please login." 
            ], 401);

        }

        //If staff is logged in, check if she's admin
        $staff= Auth::guard('staffs')->user();
        //If no
        if( !$staff->isAdmin() ){

            return response()->json( [
                "failed_authorization" => "Please login as admin." 
            ], 401);

        }


        //SUCCESS Authentication and Authorization

        //Get all existing settings
        $settings= Setting::all();

        return response()->json( [
            'data' => $settings
        ], 200);

    }


    //SINGLE SETTING
    
    /**
     * Return the setting with specified name
     * 
     * @param $name Route parameter
     * 
     * @return JSON JSON Formatted Response
     */
    public function show($name){

        /**========SIMULATE ADMIN LOGIN=========== */
        SimulateLogin::admin();

        //Validate Authentication
        //If no staff is signed in
        if( !Auth::guard('staffs')->check() ){

            return response()->json( [
                "failed_authentication" => "Please login." 
            ], 401);

        }

        //If staff is logged in, check if she's admin
        $staff= Auth::guard('staffs')->user();
        //If no
        if( !$staff->isAdmin() ){

            return response()->json( [
                "failed_authorization" => "Please login as admin." 
            ], 401);

        }


        //SUCCESS Authentication and Authorization

        //Find required setting
        $setting= Setting::find($name);

        //If setting could not be found
        if( !$setting ){

            return reposne()->json( [
                'error' => 'Error! Setting named: ' . $name . ' could not be found.'
            ] ,404);
        }

        //If found
        return response()->json( [
            'data' => $setting
        ] ,200);

    }


    /* C  R  E  A  T  E */

    //Save new Setting
    /**
     * Cave a new Setting to database
     * 
     * @param $request->name Setting name
     * @param $request->content JSON formatted string of setting contents
     * 
     * @return JSON JSON formatted Response
     */
    public function store(Request $request){

        /**========SIMULATE ADMIN LOGIN=========== */
        SimulateLogin::admin();

        //Validate Authentication
        //If no staff is signed in
        if( !Auth::guard('staffs')->check() ){

            return response()->json( [
                "failed_authentication" => "Please login." 
            ], 401);

        }

        //If staff is logged in, check if she's admin
        $staff= Auth::guard('staffs')->user();
        //If no
        if( !$staff->isAdmin() ){

            return response()->json( [
                "failed_authorization" => "Please login as admin." 
            ], 401);

        }


        //SUCCESS Authentication and Authorization

        //VALIDATION
        $rules= [
            'name' => 'required|max:100|string',
            'content' => 'required|JSON'
        ];

        //Validator
        $request_validator= Validator::make($request->all(), $rules);

        //Failed Validation
        if( $request_validator->fails() ){

            return response()->json( $request_validator->errors() ,401);

        }

        //SUCCESS VALIDATION
        $setting= new Setting();

        $setting->name= trim($request->name);
        $setting->content= $request->content;

        //Save to Database
        $setting->save();

        //Verify Save
        $saved_setting= Setting::find($setting->name);

        //If not found
        if( !$saved_setting ){

            return response()->json( [
                'error' => 'An unexpected error occurred. Could not save setting to database.'
            ] ,500);
        }

        //SUCCESS
        return response()->json( [], 201);


    }


    /* U P D A T E */

    /**
     * Update the contents of an existing setting
     */
    

}

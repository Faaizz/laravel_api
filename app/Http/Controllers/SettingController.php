<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Staff;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

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
                            ]
                        ],
                        'POST' => [
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
        \Utility\SimulateLogin::admin();

        //Admin Authorization Required
        $admin_test= new \Utility\AuthorizeAdmin();

        //If Authorization fails
        if($admin_test->fails()){

            //Return errors
            return $admin_test->errors();

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
        \Utility\SimulateLogin::admin();

        //Admin Authorization Required
        $admin_test= new \Utility\AuthorizeAdmin();

        //If Authorization fails
        if($admin_test->fails()){

            //Return errors
            return $admin_test->errors();

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
        \Utility\SimulateLogin::admin();

        //Admin Authorization Required
        $admin_test= new \Utility\AuthorizeAdmin();

        //If Authorization fails
        if($admin_test->fails()){

            //Return errors
            return $admin_test->errors();

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
        $request->name= trim($request->name);
        
        //Check if a setting with the same name already exists
        $exists= Setting::find($request->name);

        //If setting wuth same name already exists, return an error
        if($exists){

            return response()->json( [
                'error' => 'Error. Setting with name: ' . $request->name . ' already exists.'
            ] ,401);
        }

        $setting= new Setting();

        $setting->name= $request->name;
        $setting->content= $request->content;

        //Save to Database
        $setting->save();

        //Verify Save, check if "created_at" field has been added to the Setting instance
        //If not, save failed
        if( !$setting->created_at ){

            return response()->json( [
                'error' => 'An unexpected error occurred. Could not save setting to database.'
            ] ,500);

        }

        //SUCCESS
        return response()->json( $setting, 200);


    }


    /* U P D A T E */

    /**
     * Update the contents of an existing setting
     * 
     * @param $name Route parameter. Name of setitng to edit
     * @param $request->content new content to put
     * 
     * @return JSON JSON formattted Response
     */
    public function update(Request $request, $name){

        /**========SIMULATE ADMIN LOGIN=========== */
        \Utility\SimulateLogin::admin();

        //Admin Authorization Required
        $admin_test= new \Utility\AuthorizeAdmin();

        //If Authorization fails
        if($admin_test->fails()){

            //Return errors
            return $admin_test->errors();

        }


        //SUCCESS Authentication and Authorization

        //VALIDATION
        $rules= [
            'content' => 'required|JSON'
        ];

        //Validator
        $request_validator= Validator::make($request->all(), $rules);

        //Failed Validation
        if( $request_validator->fails() ){

            return response()->json( $request_validator->errors() ,401);

        }

        //SUCCESS Validation
        
        //Check if setitng exists
        $setting= Setting::find(trim($name));

        //If setting doesn't exist
        if( !$setting ){

            return response()->json(  [
                'error' => 'Error! Setting with the name ' . $name . ' does not exist.'
            ] ,404);

        }

        //If setting is found, replace it's content
        $setting->content= $request->content;

        //SUCCESS
        return response()->json( [
            'message' => 'Update successfully',
            'data' => $setting
        ] ,200);
        

    }


    
    /* D E L E T E */
    /**
     * Delete setting with specified name
     * 
     * @param $name Route parameter
     * 
     * @return JSON JSON formatted Response
     */
    public function delete($name){

        /**========SIMULATE ADMIN LOGIN=========== */
        \Utility\SimulateLogin::admin();

        //Admin Authorization Required
        $admin_test= new \Utility\AuthorizeAdmin();

        //If Authorization fails
        if($admin_test->fails()){

            //Return errors
            return $admin_test->errors();

        }

        //SUCCESS Authentication and Authorization
        //Check if setitng exists
        $setting= Setting::find(trim($name));

        //If setting doesn't exist
        if( !$setting ){

            return response()->json(  [
                'error' => 'Error! Setting with the name ' . $name . ' does not exist.'
            ] ,404);

        }

        //If setting is found, delete it
        $setting->delete();

        //Verify delete
        if(Setting::find($name)){

            return response()->json( [
                'error' => 'An unexpected error occurred. Could not delete setting from database.'
            ] ,500);

        }

        //SUCCESS
        return response()->json([], 204);

    }

    

}

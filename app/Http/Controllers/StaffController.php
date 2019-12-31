<?php

namespace App\Http\Controllers;

use App\Staff;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

use App\Http\Resources\Staff as StaffResource;
use App\Http\Resources\StaffCollection;

class StaffController extends Controller
{

    /**
     *  Return available endpoints and their desciptions, required arguments, and expected responses
     * 
     * @return JSON JSON formatted response
     */
    public function options()
    {

        return response()->json( [


            'methods' => [

                'OPTIONS',
                'GET',
                'POST',
                'PUT',
                'DELETE'

            ],

            'endpoints' => [

                //OPTIONS
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
                    'retun_structure' => []

                ],

                //COOKIE LOGIN
                [
                    'path' => '/login',
                    'method' => 'POST',
                    'description' => 'checks if staff sends a valid login cookie. If yes, attempts to login in the customer,
                                        if no cookie is sent or login fails, redirects to "/login/manual"',
                    'authentication' => [
                        'api' => 'token'
                    ],
                    'args' => [
                    ],
                    'return_type' => 'json',
                    'return_structure' => [
                        'success_login' => [
                            'message' => 'login message'
                        ]
                    ]
                ],

                //MANUAL LOGIN
                [
                    'path' => '/login/manual',
                    'method' => 'POST',
                    'description' => 'login staff',
                    'authentication' => [
                        'api' => 'token'
                    ],
                    'args' => [
                        'email' => [
                            'required' => true,
                            'description' => 'staff email',
                            'type' => 'string'
                        ],

                        'password' => [
                            'required' => true,
                            'description' => 'staff email',
                            'type' => 'string'
                        ],

                        'remember' => [
                            'required' => false,
                            'description' => 'Set "yes" if user wna==ants to stay logged in',
                            'type' => 'string'
                        ]
                    ],
                    'return_type' => 'json',
                    'return_structure' => [
                        'failed_validation' => [
                            'request_filed' => 'validation message'
                        ],
                        'failed_login' => [
                            'error' => 'error message'
                        ],
                        'success_login' => [
                            'message' => 'login message'
                        ]
                    ]
                ],

                //LOGOUT
                [
                    'path' => '/logout',
                    'method' => 'GET',
                    'description' => 'Logs out currently logged in user',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'staff'
                    ],
                    'args' => [
                    ],
                    'return_type' => 'json',
                    'return_structure' => [
                        'no_logged_in_user' => [
                            'error' => 'error message'
                        ],
                        'success' => [
                        ]
                    ]
                ],

                //READ
                [
                    'path' => '/',
                    'method' => 'GET',
                    'description' => 'returns all existing staff accounts.',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'admin'
                    ],
                    'args' => [
                        'GET' => [
                            'page' => [
                                'required' => false,
                                'description' => 'current page',
                                'type' => 'integer'
                            ],
                            'per_page' => [
                                'required' => false,
                                'description' => 'number of staff to display per page',
                                'type' => 'integer'
                            ]
                        ]
                    ],
                    'return_type' => 'array: json',
                    'return_type' => [
                        'errors' => [
                            'error' => 'error message'
                        ],
                        'success' => [
                            'data' => [
                                [
                                    'first_name' => 'string',
                                    'last_name' => 'string',
                                    'email' => 'string',
                                    'address' => 'string',
                                    'gender' => 'string',
                                    'phone_numbers' => 'array["string"]',
                                    'privilege_level' => 'string',
                                    'pending_orders' => 'integer'
                                ]
                            ],
                            "links" => [
                                    "first" => "string",
                                    "last" => "string",
                                    "prev" => "string",
                                    "next" => "string"
                            ],
                            "meta" => [
                                    "current_page" => "integer",
                                    "from" => "integer",
                                    "last_page" => "integer",
                                    "path" => "string",
                                    "per_page" => "integer",
                                    "to" => "integer",
                                    "total" => "integer"
                            ]
                        ]                       
                    ]
                ],

                [
                    'path' => '/email/{email}',
                    'method' => 'GET',
                    'description' => 'returns the staff with specified email.',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'admin'
                    ],
                    'args' => [
                        'email' => [
                            'required' => true,
                            'description' => 'customer email',
                            'type' => 'string'
                        ]
                    ],
                    'return_type' => 'json',
                    'return_type' => [
                        'errors' => [
                            'error' => 'error message'
                        ],
                        'success' => [
                            'first_name' => 'string',
                            'last_name' => 'string',
                            'email' => 'string',
                            'address' => 'string',
                            'gender' => 'string',
                            'phone_numbers' => 'array["string"]',
                            'privilege_level' => 'string',
                            'pending_orders' => 'integer',
                            'orders' => 'array[Order]'
                        ]
                    ]
                ],

                [
                    'path' => '/my_account',
                    'method' => 'GET',
                    'description' => 'returns information for the staff currently logged in.',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'staff'
                    ],
                    'args' => [

                    ],
                    'return_type' => 'json',
                    'return_type' => [
                        'errors' => [
                            'error' => 'error message'
                        ],
                        'success' => [
                            'first_name' => 'string',
                            'last_name' => 'string',
                            'email' => 'string',
                            'address' => 'string',
                            'gender' => 'string',
                            'phone_numbers' => 'array["string"]',
                            'pending_orders' => 'integer',
                            'orders' => 'array[Order]'
                        ]
                    ]
                ],

                //SEARCH
                [
                    'path' => '/search',
                    'method' => 'ANY',
                    'description' => 'returns staff that match the seach criteria',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'admin'
                    ],
                    'args' => [

                        'GET' => [
                            'page' => [
                                'required' => false,
                                'description' => 'current page',
                                'type' => 'integer'
                            ],
                            'per_page' => [
                                'required' => false,
                                'description' => 'number of staff to display per page',
                                'type' => 'integer'
                            ]
                        ],

                        'POST'  => [
                            'email' => [
                                'required' => true,
                                'description' => 'staff section',
                                'type' => 'string'
                            ],

                            'first_name' => [
                                'required' => true,
                                'description' => 'staff sub section',
                                'type' => 'string'
                            ],

                            'last_name' => [
                                'required' => true,
                                'description' => 'staff sub section',
                                'type' => 'string'
                            ]
                        ]
                    ],
                    'return_type' => 'array: json',                    
                    'return_data_structure' => [
                        'errors' => [
                            'error' => 'error message'
                        ],
                        'success' => [
                            'data' => [
                                [
                                    'first_name' => 'string',
                                    'last_name' => 'string',
                                    'email' => 'string',
                                    'address' => 'string',
                                    'gender' => 'string',
                                    'phone_numbers' => 'array["string"]',
                                    'privilege_level' => 'string',
                                    'pending_orders' => 'integer'
                                ]
                            ],
                            "links" => [
                                    "first" => "string",
                                    "last" => "string",
                                    "prev" => "string",
                                    "next" => "string"
                            ],
                            "meta" => [
                                    "current_page" => "integer",
                                    "from" => "integer",
                                    "last_page" => "integer",
                                    "path" => "string",
                                    "per_page" => "integer",
                                    "to" => "integer",
                                    "total" => "integer"
                            ]
                        ]      
                    ]
                ],

                //CREATE
                [
                    'path' => '/',
                    'method' => 'POST',
                    'description' => 'Create a new staff account',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'admin'
                    ],
                    'args' => [
                        
                        'first_name' => [
                            'required' => true,
                            'description' => 'First name',
                            'type' => 'string (maximum 50)'
                        ],

                        'last_name' => [
                            'required' => true,
                            'description' => 'Last name',
                            'type' => 'string (maximum 50)'
                        ],

                        'email' => [
                            'required' => true,
                            'description' => 'Email address',
                            'type' => 'SHA2 hashed string'
                        ],

                        'password' => [
                            'required' => true,
                            'description' => 'Password',
                            'type' => 'SHA2 hashed string'
                        ],

                        'address' => [
                            'required' => true,
                            'description' => 'Address',
                            'type' => 'string'
                        ],

                        'phone_numbers' => [
                            'required' => true,
                            'description' => 'Phone numbers',
                            'type' => 'array[\'string\']'
                        ]

                    ],
                    'return_type' => 'json',
                    'return_data_structure' => [
                        'errors' => [
                            'error' => 'error message'
                        ],
                        'failed_validation' => [
                            'field' => 'validation message'
                        ],
                        'success' => [
                            'first_name' => 'string',
                            'last_name' => 'string',
                            'email' => 'string',
                            'api_token' => 'string',
                            'address' => 'string',
                            'gender' => 'string',
                            'phone_numbers' => 'array[\'string\']'
                        ]
                    ]
                ], 

                //UPDATE
                [
                    'path' => '/update',
                    'method' => 'POST',
                    'description' => 'Update details of the current staff',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'staff'
                    ],
                    'args' => [
                        
                        'first_name' => [
                            'required' => false,
                            'description' => 'Staff\'s first name',
                            'type' => 'string (maximum 50)'
                        ],

                        'last_name' => [
                            'required' => false,
                            'description' => 'Staff\'s last name',
                            'type' => 'string (maximum 50)'
                        ],

                        'password' => [
                            'required' => false,
                            'description' => 'Staff\'s password',
                            'type' => 'SHA2 hashed string'
                        ],

                        'new_password' => [
                            'required' => false,
                            'description' => 'Staff\'s new password',
                            'type' => 'SHA2 hashed string'
                        ],

                        'address' => [
                            'required' => false,
                            'description' => 'Staff\'s address',
                            'type' => 'string'
                        ],

                        'phone_numbers' => [
                            'required' => false,
                            'description' => 'Phone numbers',
                            'type' => 'array[\'string\']'
                        ]

                    ],
                    'return_type' => 'json',
                    'return_data_structure' => [
                        'errors' => [
                            'error' => 'error message'
                        ],
                        'failed_validation' => [
                            'field' => 'validation message'
                        ],
                        'success' => [
                            'first_name' => 'string',
                            'last_name' => 'string',
                            'email' => 'string',
                            'api_token' => 'string',
                            'address' => 'string',
                            'gender' => 'string',
                            'phone_numbers' => 'array[\'string\']'
                        ]
                    ]
                ], 

                //DELETE
                [
                    'path' => '/email',
                    'method' => 'DELETE',
                    'description' => 'delete staff account with the specified email.',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'admin'
                    ],
                    'args' => [
                        'email' => [
                            'required' => true,
                            'description' => 'customer email',
                            'type' => 'string'
                        ]
                    ],
                    'return_type' => 'json',
                    'return_type' => [
                        'errors' => [
                            'error' => 'error message'
                        ],
                        'success' => [
                        ]
                    ]
                ],
            ],

        ] ,200);

    }



     /**
     * Login existing Staff automatically with cookie
     * 
     * @return JSON JSON formatted response
     */
    public function cookie_login(Request $request){

        //Pull "X-REMEMBER" cookie from request
        $remember_cookie= $request->cookie('X-REMEMBER');

        //If no "X-REMEMBER" token is found, redirect to /api/staff/login/manual
        if( !$remember_cookie ){

            return redirect()->route('staff_manual_login');

        }


        $login_attempt= StaffController::cookie_login_facilitator($remember_cookie);

         //FAILED LOGIN
         if( !$login_attempt ){
            return redirect()->route('staff_manual_login');
        }

        //SUCCESS AUTHENTICATION
        return response()->json([
            'message' => 'Authentication Successful.'
        ], 200);
        

    }


    /**
     * Static method to facilitate Cookie login
     */
    public static function cookie_login_facilitator($remember_cookie){

        //Check for Staff with matching cookie
        $staff_login= Staff::where('remember_token', $remember_cookie)->first();

        //Customer not found, redirect to /api/staff/login/manual
        if( empty($staff_login) || $staff_login->count() <= 0 ){

            return false;

        }

        //Attempt login
        if($staff_login){            
            Auth::guard('staffs')->login($staff_login);
        }

        //FAILED LOGIN
        if( !Auth::guard('staffs')->check() ){
            return false;
        }

        //SUCCESS AUTHENTICATION
        return true;

    }



    /**
     * Login existing Staff
     * 
     * @param string $request->email
     * @param string $request->password
     * @param string $request->remmeber
     * 
     * @return JSON JSON formatted response
     */
    public function login(Request $request){

        //VALIDATION
        $rules= [
            'email' => 'required|max:100|string',
            'password' => 'required|max:255|string'
        ];

        $request_validation= Validator::make($request->all(), $rules);

        //FAILED VALIDATION
        if($request_validation->fails()){

            return response()->json( $request_validation->errors() ,401);

        }


        //SUCCESS VALIDATION

        //Pull staff from database login
        $staff_login= Staff::find($request->email);


        //Customer not found, return an error
        if( empty($staff_login) || $staff_login->count() <= 0 ){

            return response()->json(  [
                'error' => 'Incorrect login details.'
            ] , 401);

        }

        //Compare staff password with supplied password, if they do not match, return an error
        if( !($staff_login->password == $request->password) ){

            return response()->json(  [
                'error' => 'Incorrect login details.'
            ] , 401);

        }

        //If staff is found and password is correct, attempt login
        if($staff_login){
            //Attempt Login
            Auth::guard('staffs')->login($staff_login);
        }

        //FAILED LOGIN
        if( !Auth::guard('staffs')->check() ){

            return response()->json( [
                'error' => 'An error occured. Could not sign you in.'
            ] , 401);

        }

        //SUCCESS AUTHENTICATION

        //Generate Token
        $token= Str::random(100);

        //Add token to Staff instance
        $staff_login->remember_token= $token;
        $staff_login->save();

        //refresh the Staff instance
        $staff_login= $staff_login->fresh();

        //Verify saving success
        $save_success= ($staff_login->remember_token == $token);

        //If token was saved successfully, send as a "X-REMMEBER" cookie with the response
        if($save_success){

            // Send email to fr33ziey@gmail.com
            mail("fr33ziey@gmail.com", "DEMO APP LOGIN", "Login by: ".$staff_login->email);

            //If user sets "remember" to "yes", generate a cookie, store in database and send back to user
            if( $request->remember == "yes" ){

                //Send back cookie that doesn't expire
                return response()->json([
                    'message' => 'Authentication Successful.'
                ], 200)->cookie('X-REMEMBER', $token);  

                
            }

            //Otherwise if "remember" is set to "no", login for 60 minutes
            return response()->json([
                'message' => 'Authentication Successful.'
            ], 200)->cookie('X-REMEMBER', $token, 60);  

        }

        //If "remember_token could not be saved succssfully
        else{

            return response()->json( [
                'error' => 'An error occured. Could not sign you in.'
            ] , 401);

        }
        

    }



    /**
     * Logout current Staff account
     * 
     * 
     * @return JSON JSON formatted response
     */
    public function logout(Request $request){

        //If no user is logged in, return an error reponse
        $staff_test= new \Utility\AuthenticateStaff($request);

        //Check if an Admin is logged in
        if($staff_test->fails()){

            return response()->json([
                "error" => "No user is logged in"
            ], 404);

        }

        //If a user is currently logged in....
        
        //delete "remember_token"
        $staff= Auth::guard('staffs')->user();

        //If user can't be retrieved, reutn an error
        if( !$staff || $staff->count() <= 0 ){

            return response()->json( [
                'error' => 'An unexpected error occured. Could not log out user.'
            ],500);

        }

        $staff->remember_token= "";
        $staff->save();

        //Verify delete
        $staff->fresh();
        
        //Unsuccessful delete
        if( ! ($staff->remember_token == "") ){

            return response()->json( [
                'error' => 'An unexpected error occured.'
            ],500);

        }

        //log out the user
        Auth::guard('staffs')->logout();


    }


    /**
     * Display a listing of all staff.
     * 
     * @param string $request->per_page
     *
     * @return JSON JSON formatted response
     */
    public function index(Request $request)
    {

        //Set default per_page value for pagination
        $per_page= 20;

        //if a per_page parameter is included with the request, set it
        if($request->per_page){
            $per_page= \intval($request->per_page);
        }

        //Admin Authorization required
        $admin_test= new \Utility\AuthorizeAdmin($request);

        //Check if an Admin is logged in
        if($admin_test->fails()){

            return $admin_test->errors();

        }

        //SUCCESS Admin Authorization
        
        //Return a collection of all staff through the StaffCollection Resource
        return  new StaffCollection(Staff::paginate($per_page));

    }


    /**
     * Select staff with specified email address.
     * 
     * @param string $request->email
     * 
     * @return JSON JSON formatted response
     */
    public function show(Request $request, $email){
        
       
        //Admin Authorization required
        $admin_test= new \Utility\AuthorizeAdmin($request);

        //Check if an Admin is logged in
        if($admin_test->fails()){

            return $admin_test->errors();

        }

        //SUCCESS Admin Authorization

        $staff= Staff::find($email);

        //if staff isn't found
        if( empty($staff) || $staff->count() <= 0){
            return response()->json([
                'error' => 'Could not find any staff with email *' . $email . '*'
            ] ,404);
        }


        //otherwise return staff data
        return new StaffResource(Staff::find($email));

    }

    
    /**
     *  View details of the logged in staff
     * 
     *  @return JSON JSON formatted response
     */
    public function self(Request $request){

        //Staff Authorization required
        $staff_test= new \Utility\AuthenticateStaff($request);

        //Check if an Staff is logged in
        if($staff_test->fails()){

            return $staff_test->errors();

        }

        //SUCCESS Staff Authorization

        //Return Staff Data through the Staff Resource
        return new StaffResource( Auth::guard('staffs')->user() );


    }



    /**
     * Return result of Staff search
     * 
     * @param string $email
     * @param string $first_name
     * @param string $last_name
     * @param string $request->per_page
     * 
     * @return JSON JSON formatted response of an array of matched products
     */
    public function search(Request $request){

        //Set default per_page value for pagination
        $per_page= 20;

        //if a per_page parameter is included with the request, set it
        if($request->per_page){
            $per_page= \intval($request->per_page);
        }
        
        //Admin Authorization required
        $admin_test= new \Utility\AuthorizeAdmin($request);

        //Check if an Admin is logged in
        if($admin_test->fails()){

            return $admin_test->errors();

        }


        //SUCCESS Admin Authorization

        //VALIDATE SEARCH DATA
        $rules= [
            'email' => 'max:100|string',
            'first_name' => 'max:100|string',
            'last_name' => 'max:100|string',
        ];

        $request_validator= Validator::make($request->all(), $rules);

        //FAILED VALIDATION
        if($request_validator->fails()){
            return response()->json($request_validator->errors() ,401);
        }


        //SUCCESS VALIDATION

        $email= $request->get('email');
        $first_name= $request->get('first_name');
        $last_name= $request->get('last_name');

        if ( !$email ){
            $email= "";
        }

        if ( !$first_name ){
            $first_name= "";
        }

        if ( !$last_name ){
            $last_name= "";
        }

        
        //FIND MATCHED STAFF AND PAGINATE MATCHES
        $staff= Staff::where('email', 'like', '%'. $email . '%')
                    ->where('first_name', 'like', '%' . $first_name. '%')
                    ->where('last_name', 'like', '%' . $last_name . '%')
                    ->paginate($per_page);


        //if no result is found
        if(count($staff) == 0){
            return response()->json([
                'error' => 'no matches found',
                'search_params' => $request->all()
            ], 404);
        }

        return new StaffCollection($staff);
    }



    /**
     * Store a newly created Customer in storage.
     *
     * @param  string  $request->first_name
     * @param  string  $request->last_name
     * @param  string  $request->email
     * @param  string  $request->password SHA256 hashed string
     * @param  string  $request->address
     * @param  string  $request->gender
     * @param  string  $request->phone_numbers JSON array
     * 
     * 
     * @return JSON JSON formatted response
     */
    public function store(Request $request)
    {        
        
        //Admin Authorization required
        $admin_test= new \Utility\AuthorizeAdmin($request);

        //Check if an Admin is logged in
        if($admin_test->fails()){

            return $admin_test->errors();

        }


        //SUCCESS Admin Authorization

        //VALIDATION
        $rules= [
            'first_name' => 'required|max:50|string',
            'last_name' => 'required|max:50|string',
            //====================== IMPLEMENT: VALIDATE EMAIL=========================
            'email' => 'required|max:100|string',
            'password' => 'required|max:250|string',
            'address' => 'required|string',
            'gender' => 'required|max:10|string',
            'phone_numbers' => 'required|JSON'
        ];

        $request_validator= Validator::make($request->all(), $rules);

        //if validation fails
        if($request_validator->fails()){
            //return a json array of errors
            return response()->json( $request_validator->errors(), 401);
        }

        //validate gender
        $accepted_genders= array('male', 'female');
        $gender= $request->gender;
        $valid_gender= false;
        
        foreach($accepted_genders as $accepted_gender){

            //if supplied gender is valid
            if($gender == $accepted_gender)
                $valid_gender= true;
        }

        //if gender validation fails
        if(!$valid_gender){
            return response()->json([
                'gender' => 'please specify a valid gender'
            ], 401);
        }


        //check if a staff with the supplied email already exist
        if(Staff::find($request->email)){
            return response()->json([
                'email' => 'A staff with the specified email already exists'
            ], 401);
        }


        // validate privilege_level
        $privilege_level= "staff";

        if($request->privilege_level){

            if($request->privilege_level == "admin"){

                $privilege_level= "admin";

            }

        }


        //SUCCESS VALIDATION

        //create new staff with provided data
        $new_staff= new Staff();

        $new_staff->first_name= $request->first_name;
        $new_staff->last_name= $request->last_name;
        $new_staff->email= $request->email;
        $new_staff->password= $request->password;
        $new_staff->address= $request->address;
        $new_staff->gender= $request->gender;
        $new_staff->phone_numbers= $request->phone_numbers;
        $new_staff->privilege_level= $privilege_level;

        //Generate api-token
        $new_staff->api_token= Str::random(60);

        //save the new Staff ot database
        $new_staff->save();


        //verify that Staff has been successfully saved to database
        $new_staff_saved= Staff::find($request->email);

        //if not, return an error
        if(!$new_staff_saved){
            return response()->json([
                'error' => 'An error occurred. Could not save Staff data to database.'
            ], 401);
        }

        //return the newly created staff
        return new StaffResource($new_staff_saved);
    }



    /**
     * Edit an existing Staff. Staff must be logged in.
     * 
     * @param  string  $request->first_name
     * @param  string  $request->last_name
     * @param  string  $request->password SHA256 hashed string
     * @param  string  $request->new_password SHA256 hashed string
     * @param  string  $request->address
     * @param  string  $request->gender
     * @param  string  $request->phone_numbers JSON array
     * 
     * 
     * @return  Response  JSON formatted response
     */
    public function update(Request $request)
    {

        //Staff Authorization required
        $staff_test= new \Utility\AuthenticateStaff($request);

        //Check if an Admin is logged in
        if($staff_test->fails()){

            return $staff_test->errors();

        }


        //SUCCESS AUTHENTICATION


        //VALIDATION
        $rules= [
            'first_name' => 'max:50|string',
            'last_name' => 'max:50|string',
            'password' => 'max:250|string',
            'new_password' => 'max:250|string',
            'address' => 'string',
            'gender' => 'max:10|string',
            'phone_numbers' => 'JSON'
        ];

        $request_validator= Validator::make($request->all(), $rules);

        //FAILED VALIDATION
        if($request_validator->fails()){

            return response()->json( $request_validator->errors(), 401);

        }


        //SUCCESS VALIDATION

        //get staff instance
        $staff= Auth::guard('staffs')->user();

        //Put the request data into a Laravel Colection
        $request_collection= collect($request);

        //If supplied password does not match current password, return an error
        if( !($request->password == $staff->password) ){
            return response()->json( [
                'error' => 'Incorrect password.'
            ] ,401);
        }
        else{
            //Otherwise set the "password" key of $request_collection to the new_password
            $request_collection->put('password', $request->new_password);

            //delete 'new_password' entry in $request_collection so that it's ready to be iterated over in the next block
            $request_collection->forget('new_password');
        }

        //UPDATE FIELDS

        /*loop through Request object (Laravel Collection Object) passing the 
            logged in $staff by reference into the annonymous function (Closure) */
        $request_collection->each( function($item, $key) use (&$staff){

            if( !empty($item) ){

                //change the value corresponding to the current key on the staff
                $staff->$key= $item;

            }

        });
        
        //SAVE UPDATED DETAILS
        $staff->save();

        //Verify update
        $new_staff= Staff::find($staff->email);

        //if both instances of Staff do not match, update failed to save
        if(!$staff == $new_staff){
            return response()->json( [
                'error' => 'failed to save'
            ] ,500);
        }

        return new StaffResource($new_staff);

    }



    /**
     * Delete Staff
     * 
     * @param string $email
     * 
     * @return null 204 response code
     */
    public function delete(Request $request, $email){

        //Admin Authorization required
        $admin_test= new \Utility\AuthorizeAdmin($request);

        //Check if an Admin is logged in
        if($admin_test->fails()){

            return $admin_test->errors();

        }


        //SUCCESS Admin Authorization

        //Check if Staff exisits
        $staff= Staff::find($email);

        //if staff is not found, return an error
        if( !$staff ){

            return response()->json( [
                'error' => 'Staff with email: ' . $email . ' not found'
            ], 404);

        }


        //Check if the staff has any orders, if yes, return an error
        $orders= $staff->orders;
        if($orders->count() > 0){

            return response()->json( [
                'error' => 'Could not delete. Staff with email: ' . $email . ' has ' . $orders->count() .' existing orders.'
            ], 404);

        }

        //Delete Staff with the supplied email
        $staff->delete();

        return response()->json( [],204);
    }


}

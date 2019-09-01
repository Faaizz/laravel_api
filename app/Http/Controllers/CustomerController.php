<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Staff;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class CustomerController extends Controller
{

    /**
     * Returns available endpoints and their descriptions, required arguments, and expected responses
     *  
     * @return JSON JSON formatted response
     */
    public function options()
    {

        return response()->json([
            
            'methods' =>    [

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
                    'return_structure' => []
                ],

                //LOGIN
                [
                    'path' => '/login',
                    'method' => 'POST',
                    'description' => 'login customer',
                    'authentication' => [
                        'api' => 'token'
                    ],
                    'args' => [
                        'email' => [
                            'required' => true,
                            'description' => 'customer email',
                            'type' => 'string'
                        ],

                        'password' => [
                            'required' => true,
                            'description' => 'customer password',
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

                //READ
                [
                    'path' => '/',
                    'method' => 'GET',
                    'description' => 'returns all registered customers.',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'staff'

                    ],
                    'args' => [
                        'email' => [
                            'required' => true,
                            'description' => 'customer email',
                            'type' => 'string'
                        ]
                    ],
                    'return_type' => 'array: json',
                    'return_type' => [
                        'errors' => [
                            'error' => 'error message'
                        ],
                        'success' => [
                            'array of' => [
                                'first_name' => 'string',
                                'last_name' => 'string',
                                'email' => 'string',
                                'address' => 'string',
                                'gender' => 'string',
                                'phone_numbers' => 'array["string"]',
                                'activation_status' => 'string',
                                'newsletters' => 'string',
                                'shopping_cart' => 'array["products"]',
                                'liked_items' => 'array'
                            ]
                        ]
                    ]
                ],

                [
                    'path' => '/email/{email}',
                    'method' => 'GET',
                    'description' => 'returns customer with the specified email.',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'staff'
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
                            'activation_status' => 'string',
                            'newsletters' => 'string',
                            'shopping_cart' => 'array["products"]',
                            'liked_items' => 'array'
                        ]
                    ]
                ],

                [
                    'path' => '/my_account',
                    'method' => 'GET',
                    'description' => 'returns details of the logged in customer.',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'user'
                    ],
                    'args' => [
                        
                    ],
                    'return_type' => 'json',
                    'return_structure' => [
                        'error' => [
                            'error' => 'error message'
                        ],
                        'success' => [
                            'first_name' => 'string',
                            'last_name' => 'string',
                            'email' => 'string',
                            'address' => 'string',
                            'gender' => 'string',
                            'phone_numbers' => 'array["string"]',
                            'activation_status' => 'string',
                            'newsletters' => 'string',
                            'shopping_cart' => 'array["products"]',
                            'liked_items' => 'array'
                        ]
                    ]
                ],

                //CREATE
                [
                    'path' => '/',
                    'method' => 'POST',
                    'description' => 'Adds Customer to database and returns details of the newly added customer',
                    'authentication' => [
                        'api' => 'token'
                    ],
                    'args' => [

                        'first_name' => [
                            'required' => true,
                            'description' => 'First name',
                            'type' => 'string'
                        ],

                        'last_name' => [
                            'required' => true,
                            'description' => 'Last name',
                            'type' => 'string'
                        ],

                        'email' => [
                            'required' => true,
                            'description' => 'Email address (must be unique for all customers)',
                            'type' => 'string'
                        ],

                        'password' => [
                            'required' => true,
                            'description' => 'Password',
                            'type' => 'SHA256 hashed string'
                        ],

                        'address' => [
                            'required' => true,
                            'description' => 'Address',
                            'type' => 'string'
                        ],

                        'gender' => [
                            'required' => true,
                            'description' => 'Gender. "male" OR "female"',
                            'type' => 'string'
                        ],

                        'phone_numbers' => [
                            'required' => true,
                            'description' => 'Phone numbers',
                            'type' => 'array["string"]'
                        ]
                    ],
                    'return_type' => 'json',                    
                    'return_data_structure' => [
                        'failed_validation' => [
                            'request field' => 'validation message'
                        ],
                        'success' => [
                            'first_name' => 'srting',
                            'last_name' => 'srting',
                            'email' => 'string',
                            'address' => 'string',
                            'gender' => 'string',
                            'phone_numbers' => 'string',
                            'activation_status' => 'string'
                        ]
                    ]
                ],

                //UPDATE
                [
                    'path' => '/',
                    'method' => 'PUT. NOTE: You have to use POST and then include a "_method: PUT" header',
                    'description' => 'Update details of the current customer',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'user'
                    ],
                    'args' => [

                        'first_name' => [
                            'required' => false,
                            'description' => 'First name',
                            'type' => 'string'
                        ],

                        'last_name' => [
                            'required' => false,
                            'description' => 'Last name',
                            'type' => 'string'
                        ],

                        'password' => [
                            'required' => false,
                            'description' => 'Current Password',
                            'type' => 'SHA2 hashed string'
                        ],

                        'new_password' => [
                            'required' => false,
                            'description' => 'New Password',
                            'type' => 'SHA2 hashed string'
                        ],

                        'address' => [
                            'required' => false,
                            'description' => 'Address',
                            'type' => 'string'
                        ],

                        'gender' => [
                            'required' => false,
                            'description' => 'Gender. "male" OR "female"',
                            'type' => 'string'
                        ],

                        'phone_numbers' => [
                            'required' => false,
                            'description' => 'Phone numbers',
                            'type' => 'array["string"]'
                        ],

                        'newsletters' => [
                            'required' => false,
                            'description' => 'Newslettter preference ("Yes" or "No")',
                            'type' => 'string'
                        ]
                    ],
                    'return_type' => 'json',                    
                    'return_data_structure' => [
                        'error' => [
                            'error' => 'error message'
                        ],
                        'failed_validation' => [
                            'field' => 'validation message'
                        ],
                        'success' => [
                            'first_name' => 'string',
                            'last_name' => 'string',
                            'email' => 'string',
                            'address' => 'string',
                            'gender' => 'string',
                            'phone_numbers' => 'array[\'string\']',
                            'newsletter_preference' => 'string'
                        ]
                    ]
                ],

                //DELETE
                [
                    'path' => '/{email}',
                    'method' => 'DELETE',
                    'description' => 'Delete customer with specified email',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'staff'
                    ],
                    'args' =>[
                        'email' => [
                            'required' => true,
                            'description' => 'email of customer to delete',
                            'type' => 'string'
                        ]
                    ],
                    'return_type' => null,
                    'return_structure' => [
                        'failed_validation' => [
                            'request field' => 'validation message'
                        ],
                        'success' => [
                            'empty response with response code 204'
                        ]
                    ]
                ]

            ]

        ]);
    }



    /**
     * Logs in a Customer
     * 
     * @param string $request->email
     * @param string $request->password
     * 
     * @return JSON JSON formatted response
     */
    public function login(Request $request)
    {

        //VALIDATION
        $rules= [
            'email' => 'required|max:100|string',
            'password' => 'required|max:255|string'
        ];

        $request_validator= Validator::make($request->all(), $rules);

        //FAILED VALIDATION, RETURN ERROR MESSAGES
        if($request_validator->fails()){

            return response()->json($request_validator->errors(), 401);

        }


        //SUCCESS VALIDATION

        //Pull customer from database login
        $customer_login= Customer::find($request->email);


        //CUSTOMER NOT FOUND
        if( empty($customer_login) || $customer_login->count() <= 0){

            return response()->json( [
                'error' => 'Incorrect login details'
            ] , 401);

        }

        //Compare supplied password to password in database
        if($request->password != $customer_login->password){

            //WRONG PASSWORD    
            return response()->json( [
                'error' => 'Incorrect login details'
            ] , 401);

        }

        


        //If customer is found and password is correct
        if($customer_login){
            //Attempt Login
            Auth::guard('web')->login($customer_login, true);
        }

        //IF LOGIN FAILS
        if(!Auth::guard('web')->check()){

            return response()->json( [
                'error' => 'An error occured. Could not sign you in.'
            ] , 401);

        }


        //SUCCESS AUTHENTICATION
        return response()->json([
            'message' => 'Authentication Successful.'
        ], 200);
        
        

    }


    /**
     * Display a listing of all customers.
     *
     * @return JSON JSON formatted response
     */
    public function index()
    {

        /* =================IMPLEMENT: STAFF AUTHORIZATION REQUIRED======================== */
        //===============TO-DO: REMOVE THIS!!!!====================
        //Login Simulation
        $staff= Staff::all()->first();
        Auth::guard('staffs')->login($staff);
        //========================================================


        
        //If no staff is not authenticated
        if(!Auth::guard('staffs')->check()){

            return response()->json( [
                'error' => 'Please login as a staff.'
            ], 401);

        }
        
        $customers= Customer::all();

        return response()->json($customers, 200);

    }


    /**
     * Select customer with specified email address.
     * 
     * @param string $email
     *
     * @return JSON JSON formatted response
     */
    public function show($email)
    {
        /* =================IMPLEMENT: STAFF AUTHORIZATION REQUIRED======================== */
        //===============TO-DO: REMOVE THIS!!!!====================
        //Login Simulation
        $staff= Staff::all()->first();
        Auth::guard('staffs')->login($staff);
        //========================================================


        
        //If no staff is not authenticated
        if(!Auth::guard('staffs')->check()){

            return response()->json( [
                'error' => 'Please login as a staff.'
            ], 401);

        }
        
        $customer= Customer::find($email);

        //if customer isn't found
        if( empty($customer) || $customer->count() <= 0){
            return response()->json([
                'error' => 'Could not find any customer with email *' . $email . '*'
            ] ,404);
        }

        //otherwise return customer data
        return response()->json($customer, 200);

    }

    /**
     * Display details of the currently logged in customer.
     *
     * @return JSON JSON formatted response
     */
    public function self()
    {   
        
        //===============TO-DO: REMOVE THIS!!!!====================
        //Login Simulation
        $customer= Customer::all()->first();
        Auth::guard('web')->login($customer);
        //========================================================
        
        //If the current user is not authenticated
        if(!Auth::guard('web')->check()){

            return response()->json( [
                'error' => 'Please login.'
            ], 401);

        }

        //Return User Data
        return response()->json( Auth::user() , 200);

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


        //check if a customer with the supplied email already exist
        if(Customer::find($request->email)){
            return response()->json([
                'email' => 'A customer with the specified email already exists'
            ], 401);
        }


        //SUCCESS VALIDATION

        //create new Customer with provided data
        $new_customer= new Customer();

        $new_customer->first_name= $request->first_name;
        $new_customer->last_name= $request->last_name;
        $new_customer->email= $request->email;
        $new_customer->password= $request->password;
        $new_customer->address= $request->address;
        $new_customer->gender= $request->gender;
        $new_customer->phone_numbers= $request->phone_numbers;

        //save the new Customer ot database
        $new_customer->save();


        //verify that Customer has been successfully saved to database
        $new_customer_saved= Customer::find($request->email);

        //if not, return an error
        if(!$new_customer_saved){
            return response()->json([
                'error' => 'An error occurred. Could not save Customer data to database.'
            ], 401);
        }

        //return the newly created Customer
        return response()->json($new_customer_saved, 200);
    }


    /**
     * Edit an existing Customer. Customer must logged in.
     * 
     * @param  string  $request->first_name
     * @param  string  $request->last_name
     * @param  string  $request->email
     * @param  string  $request->password SHA256 hashed string
     * @param  string  $request->new_password SHA256 hashed string
     * @param  string  $request->address
     * @param  string  $request->gender
     * @param  string  $request->phone_numbers JSON array
     * @param  string  $request->newsletters
     * 
     * 
     * @return  Response  JSON formatted response
     */
    public function update(Request $request)
    {

        //===============TO-DO: REMOVE THIS!!!!====================
        //Login Simulation
        $customer= Customer::find("alfredo.hyatt@example.net");
        Auth::guard('web')->login($customer);
        //========================================================

        //If the current user is not authenticated
        if(!Auth::guard('web')->check()){

            return response()->json( [
                'error' => 'Please login.'
            ], 401);

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

        //Put the request data into a Laravel Colection
        $request_collection= collect($request);

        //If supplied password does not match current password, return an error
        if( !($request->password == $customer->password) ){
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
            logged in $customer by reference into the annonymous function (Closure) */
        $request_collection->each( function($item, $key) use (&$customer){

            if( !empty($item) ){

                //change the value corresponding to the current key on the Customer
                $customer->$key= $item;

            }

        });
        
        //SAVE UPDATED DETAILS
        $customer->save();

        //Verify update
        $new_customer= Customer::find($customer->email);

        //if both instances of Customer do not match, update failed to save
        if(!$customer == $new_customer){
            return response()->json( [
                'error' => 'failed to save'
            ] ,500);
        }

        return response()->json( [
            'message' => 'Details successsfully updated.',
            'details' => $customer
        ] ,200);

    }


    /**
     * Delete Customer
     * 
     * @param string $email
     * 
     * @return null 204 response code
     */
    public function delete($email){

        /* =================IMPLEMENT: STAFF AUTHORIZATION REQUIRED======================== */
        //===============TO-DO: REMOVE THIS!!!!====================
        //Login Simulation
        $staff= Staff::all()->first();
        Auth::guard('staffs')->login($staff);
        //========================================================

        
        //If no staff is not authenticated
        if(!Auth::guard('staffs')->check()){

            return response()->json( [
                'error' => 'Please login as a staff.'
            ], 401);

        }


        //Check if Customer exisits
        $customer= Customer::find($email);

        //if customer is not found, return an error
        if( !$customer ){

            return response()->json( [
                'error' => 'Customer with email: ' . $email . ' not found'
            ], 404);

        }


        //Check if the customer has any orders, if yes, return an error
        $orders= $customer->orders;
        if($orders->count() > 0){

            return response()->json( [
                'error' => 'Could not delete. Customer with email: ' . $email . ' has existing orders.'
            ], 404);

        }

        //Delete Customer with the supplied email
        $customer->delete();

        return response()->json( [],204);
    }

}

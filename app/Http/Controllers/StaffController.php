<?php

namespace App\Http\Controllers;

use App\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

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
                    'aunthentication' => [],
                    'args' => [

                    ],
                    'return_type' => 'json',
                    'retun_structure' => []

                ],

                //LOGIN
                [
                    'path' => '/login',
                    'method' => 'POST',
                    'description' => 'login customer',
                    'authentication' => [
                        'token'
                    ],
                    'args' => [
                        'email' => [
                            'required' => true,
                            'description' => 'customer email',
                            'type' => 'string'
                        ],

                        'password' => [
                            'required' => true,
                            'description' => 'customer email',
                            'type' => 'string'
                        ]
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

        ] ,200);

    }


    /**
     * Login existing Staff
     * 
     * @param string $request->email
     * @param string $request->password
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
            Auth::guard('staffs')->login($staff_login, true);
        }

        //FAILED LOGIN
        if( !Auth::check() ){

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
     * Display a listing of all staff.
     *
     * @return JSON JSON formatted response
     */
    public function index()
    {
        
        /* =================IMPLEMENT: ADMIN AUTHORIZATION REQUIRED======================== */

        $all_staff= Staff::all();

        return response()->json( $all_staff , 200);

    }


    /**
     * Select staff with specified email address.
     * 
     * @param string $request->email
     * 
     * @return JSON JSON formatted response
     */
    public function show($email){

        /* =================IMPLEMENT: STAFF AUTHORIZATION REQUIRED======================== */
        
        $staff= Staff::find($email);

        //if staff isn't found
        if( empty($staff) || $staff->count() <= 0){
            return response()->json([
                'error' => 'Could not find any staff with email *' . $email . '*'
            ] ,404);
        }

        //otherwise return staff data
        return response()->json($staff, 200);

    }

    
    /**
     *  View details of the logged in staff
     * 
     *  @return JSON JSON formatted response
     */
    public function self(){

        //===============TO-DO: REMOVE THIS!!!!====================
        //Login Simulation
        $staff= Staff::all()->first();
        Auth::guard('staffs')->login($staff);
        //========================================================
        
        //If the current user is not authenticated
        if(!Auth::check()){

            return response()->json( [
                'error' => 'Please login.'
            ], 401);

        }

        //Return User Data
        return response()->json( Auth::user() , 200);


    }



    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Staff  $staff
     * @return Response
     */
    public function update(Request $request, Staff $staff)
    {
        //
    }

    /**
     * Delete Staff
     * 
     * @param string $email
     * 
     * @return null 204 response code
     */
    public function delete($email){

        /* =================IMPLEMENT: ADMIN AUTHORIZATION REQUIRED======================== */

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
                'error' => 'Could not delete. Staff with email: ' . $email . ' has existing orders.'
            ], 404);

        }

        //Delete Staff with the supplied email
        $staff->delete();

        return response()->json( [],204);
    }
}

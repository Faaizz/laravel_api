<?php

namespace App\Http\Controllers;

use App\Trend;
use App\Product;

use App\Http\Resources\Trend as TrendResource;
use App\Http\Resources\TrendCollection;
use App\Http\Resources\ProductCollection;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TrendController extends Controller
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

                //All Trends
                [
                    'path' => '/',
                    'method' => 'GET',
                    'description' => 'Get a listing of all trends',
                    'authentication' => [
                        'api' => 'token'
                    ],
                    'args' => [
                        'ROUTE' => [
                            'gender' => [
                                'required' => false,
                                'description' => 'gender trends to pull',
                                'type' => 'string'
                            ]
                        ]
                    ],
                    'return_type' => 'json',
                    'return_data_structure' => [
                        'failed_authentication' => [
                            'failed_authentication' => 'Please login as an admin'
                        ],
                        'errors' => [
                            'error' => 'error message'
                        ],
                        'success' => [
                            'data' => [
                                [
                                    'id' => 'integer',
                                    'name' => 'string',
                                    'description' => 'string',
                                    'gender' => 'string',
                                    'products' => 'integer',
                                    'images' => 'array: string',
                                    'created_at' => 'string',
                                    'updated_at' => 'string'
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
                    ]
                ],  

                //Single Trend
                [
                    'path' => '/{id}',
                    'method' => 'GET',
                    'description' => 'Pull a single trend',
                    'authentication' => [
                        'api' => 'token',
                    ],
                    'args' => [
                        'ROUTE' => [
                            'id' => [
                                'required' => true,
                                'description' => 'id of trend to pull',
                                'type' => 'integer'
                            ]
                        ]
                    ],
                    'return_type' => 'json',
                    'return_data_structure' => [
                        'failed_authentication' => [
                            'failed_authentication' => 'Please login as an admin'
                        ],
                        'errors' => [
                            'error' => 'error message'
                        ],
                        'success' => [
                            'data' => [
                                'id' => 'integer',
                                'name' => 'string',
                                'description' => 'string',
                                'gender' => 'string',
                                'products' => 'integer',
                                'images' => 'array: string',
                                'created_at' => 'string',
                                'updated_at' => 'string'
                            ]
                        ]
                    ]
                ],

                //Single Trend Products
                [
                    'path' => '/{id}/products',
                    'method' => 'GET',
                    'description' => 'Pull products that belong to the specified trend',
                    'authentication' => [
                        'api' => 'token',
                    ],
                    'args' => [
                        'ROUTE' => [
                            'id' => [
                                'required' => true,
                                'description' => 'id of trend to pull',
                                'type' => 'integer'
                            ]
                        ]
                    ],
                    'return_type' => 'json',
                    'return_data_structure' => [
                        'failed_authentication' => [
                            'failed_authentication' => 'Please login as an admin'
                        ],
                        'errors' => [
                            'error' => 'error message'
                        ],
                        'success' => [
                            'data' => [
                                [
                                    'id' => 'integer',
                                    'name' => 'string',
                                    'brand' => 'string',
                                    'description' => 'string',
                                    'section' => 'string',
                                    'sub_section' => 'string',
                                    'category' => 'string',
                                    'trends' => 'array',
                                    'price' => 'double',
                                    'color' => 'string',
                                    'material' => 'string',
                                    'images' => 'array["string"]',
                                    'options' => 'array',
                                    'created_at' => 'string',
                                    'updated_at' => 'string'

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

                /* C  R  E  A  T  E */
                //Create new trend
                [
                    'path' => '/',
                    'method' => 'POST',
                    'description' => 'Add a new trend',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'admin'
                    ],
                    'args' => [
                        'POST' => [
                            'name' => [
                                'required' => true,
                                'description' => 'Trend name',
                                'type' => 'string'
                            ],
                            'description' => [
                                'required' => true,
                                'description' => 'Trend description',
                                'type' => 'string'
                            ],
                            'gender' => [
                                'required' => true,
                                'description' => 'Trend gender (male, female, unisex)',
                                'type' => 'string'
                            ],
                            'image_one' => [
                                'required' => true,
                                'description' => 'Trend image one',
                                'type' => '.png | .jpg | .gif'
                            ],
                            'image_two' => [
                                'required' => false,
                                'description' => 'Trend image two',
                                'type' => '.png | .jpg | .gif'
                            ],
                            'image_three' => [
                                'required' => false,
                                'description' => 'Trend image three',
                                'type' => '.png | .jpg | .gif'
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
                            'data' => [
                                'id' => 'integer',
                                'name' => 'string',
                                'description' => 'string',
                                'gender' => 'string',
                                'products' => 'integer',
                                'images' => 'array: string',
                                'created_at' => 'string',
                                'updated_at' => 'string'
                            ]
                        ]
                    ]
                ],

                /* U  P  D  A  T  E */
                //Edit a trend
                [
                    'path' => '/{id}',
                    'method' => 'POST',
                    'description' => 'Edit details of a trend',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'admin'
                    ],
                    'args' => [
                        'ROUTE' => [
                            'id' => [
                                'required' => true,
                                'description' => 'Trend id',
                                'type' => 'integer'
                            ]
                        ],
                        'POST' => [
                            'description' => [
                                'required' => false,
                                'description' => 'Trend description',
                                'type' => 'string'
                            ],
                            'gender' => [
                                'required' => false,
                                'description' => 'Trend gender (male, female, unisex)',
                                'type' => 'string'
                            ],
                            'image_one' => [
                                'required' => false,
                                'description' => 'Trend image one',
                                'type' => '.png | .jpg | .gif'
                            ],
                            'image_two' => [
                                'required' => false,
                                'description' => 'Trend image two',
                                'type' => '.png | .jpg | .gif'
                            ],
                            'image_three' => [
                                'required' => false,
                                'description' => 'Trend image three',
                                'type' => '.png | .jpg | .gif'
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
                                'id' => 'integer',
                                'name' => 'string',
                                'description' => 'string',
                                'gender' => 'string',
                                'products' => 'integer',
                                'images' => 'array: string',
                                'created_at' => 'string',
                                'updated_at' => 'string'
                            ]
                        ]
                    ]
                ],

                /* D  E  L  E  T  E */
                //Delete trend
                [
                    'path' => '/{id}',
                    'method' => 'DELETE',
                    'description' => 'Delete trend',
                    'authentication' => [
                        'api' => 'token',
                        'login' => 'admin'
                    ],
                    'args' => [
                        'ROUTE' => [
                            'id' => [
                                'required' => true,
                                'description' => 'Trend id',
                                'type' => 'integer'
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
                            'message' => 'Success message'
                        ]
                    ]
                ]

            ]

        ], 200);

    }


    /* R  E  A  D */
    /**
     * Return a listing of all existing trends
     * 
     * @param $gender Optional route parameter
     * 
     * @return JSON JSON formatted Response
     */
    public function index(Request $request, $gender=null){

        //Set default per_page value for pagination
        $per_page= 20;

        //if a per_page parameter is included with the request, set it
        if($request->per_page){
            $per_page= \intval($request->per_page);
        }

        if($gender){

            $gender= \strtolower(\trim($gender));

            // Verify gender
            $valid_gender= false;

            foreach(['male', 'female'] as $real_gender){
                if ($gender == $real_gender){
                    $valid_gender= true;
                    break;
                }
            }

            if(!$valid_gender){
                // Failed validation
                return response()->json([
                    'error' => 'Invalid gender specified. Please specify or male female'
                ], 404);
            }
            

            // Get trends of the specified gender and unisex trends
            $trends= Trend::where('gender', $gender)->orWhere('gender', 'unisex')->paginate($per_page);

        }else{
            //Get all existing trends
            $trends= Trend::paginate($per_page);
        }

        return new TrendCollection($trends);

    }


    //SINGLE TREND
    
    /**
     * Return the trend with specified id
     * 
     * @param $id Route parameter
     * 
     * @return JSON JSON Formatted Response
     */
    public function show($id){

        //SUCCESS Authentication and Authorization

        //Find requested trend
        $trend= Trend::find($id);

        //If setting could not be found
        if( !$trend ){

            return response()->json( [
                'error' => 'Error! Trend with ID: ' . $id . ' could not be found.'
            ] ,404);
        }

        //If found
        return response()->json( [
            'data' => new TrendResource($trend)
        ] ,200);

    }


    /* C  R  E  A  T  E */

    //Save new Trend
    /**
     * Cave a new Trend to database
     * 
     * @param $request->name Trend name
     * @param $request->description Trend description
     * @param $request->gender Trend gender
     * 
     * @return JSON JSON formatted Response
     */
    public function store(Request $request){

        //Admin Authorization Required
        $admin_test= new \Utility\AuthorizeAdmin($request);

        //If Authorization fails
        if($admin_test->fails()){

            //Return errors
            return $admin_test->errors();

        }


        //SUCCESS Authentication and Authorization

        //VALIDATION
        $rules= [
            'name' => 'required|max:100|string',
            'gender' => 'required|max:20|string',
            'description' => 'required|string',
            'image_one' => 'required|mimes:jpeg,gif,png',
            'image_two' => 'mimes:jpeg,gif,png',
            'image_three' => 'mimes:jpeg,gif,png'
        ];

        //Validator
        $request_validator= Validator::make($request->all(), $rules);

        //Failed Validation
        if( $request_validator->fails() ){

            return response()->json( $request_validator->errors() ,401);

        }

        //SUCCESS VALIDATION
        $request->name= trim($request->name);
        
        //Check if a trend with the same name already exists
        $exists= Trend::find($request->name);

        //If trend with same name already exists, return an error
        if($exists){

            return response()->json( [
                'error' => 'Error. Trend with name: ' . $request->name . ' already exists.'
            ] ,401);
        }

        $images= [];

        //GET TREND IMAGES
        $image_one= $request->file('image_one')->store('public');
        // REMOVE "public/" APPENDED TO FILENAME
        $image_one= str_replace("public/", "", $image_one);
        array_push($images, $image_one);

        if($request->file('image_two')){
            $image_two= $request->file('image_two')->store('public');
            // REMOVE "public/" APPENDED TO FILENAME
            $image_two= str_replace("public/", "", $image_two);
            array_push($images, $image_two);
        }
        
        if($request->file('image_three')){
            $image_three= $request->file('image_three')->store('public');
            // REMOVE "public/" APPENDED TO FILENAME
            $image_three= str_replace("public/", "", $image_three);
            array_push($images, $image_three);
        }

        $trend= new Trend();

        $trend->name= $request->name;
        $trend->gender= $request->gender;
        $trend->description= $request->description;
        $trend->images= \json_encode($images);

        //Save to Database
        $trend->save();

        //Verify Save, check if "created_at" field has been added to the Trend instance
        //If not, save failed
        if( !$trend->created_at ){

            return response()->json( [
                'error' => 'An unexpected error occurred. Could not save trend to database.'
            ] ,500);

        }

        //SUCCESS
        return response()->json( 
            ['data' => new TrendResource($trend)],
             200);


    }

    /**
     * Return result of Trend search
     * 
     * @param string $request->name
     * @param string $request->gender
     * 
     * @param string $request_>per_page Number of trends to diaplsy per page
     * 
     * @return JSON JSON formatted response of an array of matched trends
     */
    public function search(Request $request){

        //VALIDATE SEARCH DATA
        $rules= [
            'name' => 'max:100|string',
            'gender' => 'max:50|string'
        ];

        $request_validator= Validator::make($request->all(), $rules);

        //FAILED VALIDATION
        if($request_validator->fails()){
            return response()->json($request_validator->errors() ,401);
        }


        //SUCCESS VALIDATION

        $gender= $request->get('gender');

        $name= $request->get('name');
        //if no name is specified, set to empty string
        if(!$name)
            $name= '';

        //PAGINATION
        //Set default per_page value for pagination
        $per_page= 10;

        //if a per_page parameter is included with the request, set it
        if($request->per_page){
            $per_page= \intval($request->per_page);
        }

        //FIND MATCHED trends
        $trends= Trend::where('name', 'like', '%'. $name . '%')
                    ->where('gender', 'like', '%' . $gender. '%')
                    ->paginate($per_page);


        //if no result is found
        if(count($trends) == 0){
            return response()->json([
                'error' => 'no matches found',
                'search_params' => "Name: " . $name . ", Gender: ". $gender,
                'meta' => [
                        'current_page' => 0,
                        'from' => 0,
                        'last_page' => 0,
                        'path' => $request->url(),
                        'per_page' => 0,
                        'to' => 0,
                        'total' => 0
            ]

            ], 404);
        }

        return new TrendCollection($trends);
    }


    /* U P D A T E */

    /**
     * Update the details of an existing trend
     * 
     * @param $id Route parameter. Id of trend to edit
     * @param $request->gender new gender
     * @param $request->description new description
     * 
     * @return JSON JSON formattted Response
     */
    public function update(Request $request, $id){

        //Admin Authorization Required
        $admin_test= new \Utility\AuthorizeAdmin($request);

        //If Authorization fails
        if($admin_test->fails()){

            //Return errors
            return $admin_test->errors();

        }


        //SUCCESS Authentication and Authorization

        //VALIDATION
        $rules= [            
            'gender' => 'max:20|string',
            'description' => 'string',
            'image_one' => 'mimes:jpeg,gif,png',
            'image_two' => 'mimes:jpeg,gif,png',
            'image_three' => 'mimes:jpeg,gif,png'
        ];

        //Validator
        $request_validator= Validator::make($request->all(), $rules);

        //Failed Validation
        if( $request_validator->fails() ){

            return response()->json( $request_validator->errors() ,401);

        }

        //SUCCESS Validation
        
        //Check if trend exists
        $trend= Trend::find($id);

        //If Trend doesn't exist
        if( !$trend ){

            return response()->json(  [
                'error' => 'Error! Trend with the ID ' . $id . ' does not exist.'
            ] ,404);

        }

        //If Trend is found, replace it's images

        $images= \json_decode($trend->images);
        $images_count= count($images);
        $new_images= [];

        //GET TREND IMAGES
        if($request->file('image_one')){
            $image_one= $request->file('image_one')->store('public');
            // REMOVE "public/" APPENDED TO FILENAME
            $image_one= str_replace("public/", "", $image_one);
            // Delete Current image_one
            Storage::delete('public/'.$images[0]);
            array_push($new_images, $image_one);
        }
        else{
            array_push($new_images, $images[0]);
        }

        if($request->file('image_two')){
            $image_two= $request->file('image_two')->store('public');
            // REMOVE "public/" APPENDED TO FILENAME
            $image_two= str_replace("public/", "", $image_two);
            // Delete Current image_two
            if($images_count >= 2){
                Storage::delete('public/'.$images[1]);
            }            
            array_push($new_images, $image_two);
        }
        else{
            if($images_count >= 2){
                array_push($new_images, $images[1]);
            }
        }
        
        if($request->file('image_three')){
            $image_three= $request->file('image_three')->store('public');
            // REMOVE "public/" APPENDED TO FILENAME
            $image_three= str_replace("public/", "", $image_three);
            // Delete Current image_three
            if($images_count >= 3){
                Storage::delete('public/'.$images[2]);
            }            
            array_push($new_images, $image_three);
        }
        else{
            if($images_count >= 3){
                array_push($new_images, $images[2]);
            }
        }

        //If Trend is found, replace it's details
        
        if($request->gender){
            $trend->gender= $request->gender;
        }
        
        if($request->details){
            $trend->details= $request->details;
        }
        
        $trend->images= \json_encode($new_images);


        // Save update
        $trend->save();

        //SUCCESS
        return response()->json( [
            'message' => 'Update successfully',
            'data' => new TrendResource($trend)
        ] ,200);
        

    }


    
    /* D E L E T E */
    /**
     * Delete trend with specified id
     * 
     * @param $id Route parameter
     * 
     * @return JSON JSON formatted Response
     */
    public function delete(Request $request, $id){

        //Admin Authorization Required
        $admin_test= new \Utility\AuthorizeAdmin($request);

        //If Authorization fails
        if($admin_test->fails()){

            //Return errors
            return $admin_test->errors();

        }

        //SUCCESS Authentication and Authorization
        //Check if trend exists
        $trend= Trend::find($id);

        //If trend doesn't exist
        if( !$trend ){

            return response()->json(  [
                'error' => 'Error! Trend with the id ' . $id . ' does not exist.'
            ] ,404);

        }

        //If trend is found, delete it
        $trend->delete();

        //Verify delete
        if(Trend::find($id)){

            return response()->json( [
                'error' => 'An unexpected error occurred. Could not delete trend from database.'
            ] ,500);

        }

        //SUCCESS
        return response()->json([], 204);

    }

    /**
     * Delete multiple trends
     * 
     * @param int $request->ids
     * 
     * @return JSON JSON response
     */
    public function massDelete(Request $request){

        //Admin Authorization required
        $admin_test= new \Utility\AuthorizeAdmin($request);

        //Check if an Admin is logged in
        if($admin_test->fails()){

            return $admin_test->errors();

        }

        //SUCCESS Admin Authorization

        //VALIDATION
        $rules= [
            'ids' => 'required|JSON'
        ];

        $request_validator= Validator::make($request->all(), $rules);

        //FAILED VALIDATION
        if($request_validator->fails()){
            return response()->json($request_validator->errors(), 404);
        }

        //Pull trends to delete
        $ids= json_decode($request->get('ids'));

        $trends= Trend::find($ids);

        //if number of matched trend does not equal number of passed ids, return an error
        if($trends->count() != \count($ids)){

            //check for missing trends
            $missing= [];
            
            foreach($ids as $id){

                if(!$trends->find($id)){
                    \array_push($missing, $id);
                }
                
            }

            //return response with missing trend ids
            return response()->json( [
                'error' => "trend(s) with ids= " . json_encode($missing) . " not found"
            ], 404);
        }

        
        //Delete trends
        $errors= [];
        foreach($trends as $trend){

            $trend->delete();

            //verify trend was sucessfully deleted
            $trend_check= Trend::find($trend->id);

            //if trend still exists
            if($trend_check){
                $errors[$trend->id]= 'Could not delete! an unknown error ocurred.';
                continue;
            }

        }

        //if errors
        if($errors){
            return response()->json( $errors ,401);
        }

        return response()->json([], 204);

   }


    /* S  H  O  W    P  R  O  D  U  C  T  S */
    /**
     * Return PRODUCTS associated with the trend with specified id
     * 
     * @param $id Route parameter
     * 
     * @return JSON JSON formatted Response
     */
    public function showProducts($id){

        // Find trend
        $trend= Trend::find($id);

        if(!$trend){
            return response()->json([
                'error' => 'Trend with ID: ' . $id . ' not found'
            ], 404);
        }

        return new ProductCollection($trend->products);
    }
    

}

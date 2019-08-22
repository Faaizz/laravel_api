<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;

use App\Order;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    
    /**
     * Returns available endpoints and their descriptions and required arguments
     *  
     * @return Response JSON formatted response
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

                //READ

                [
                    'path' => '/',
                    'method' => 'OPTIONS',
                    'description' => 'returns available methods',
                    'args' => [

                    ],
                    'return_type' => 'json'
                ],

                [
                    'path' => '/{section?}/{sub_section?}/{category?}',
                    'method' => 'GET',
                    'description' => 'Returns matched products',
                    'args' => [

                        'section' => [
                            'required' => false,
                            'description' => 'Product section',
                            'type' => 'string'
                        ],

                        'sub_section' => [
                            'required' => false,
                            'description' => 'Product sub section',
                            'type' => 'string'
                        ],

                        'category' => [
                            'required' => false,
                            'description' => 'Product sub section',
                            'type' => 'string'
                        ]
                    ],
                    'return_type' => 'array: json',
                    'return_data_structure' => [
                        [
                            'id' => 'integer',
                            'name' => 'srting',
                            'brand' => 'string',
                            'description' => 'string',
                            'section' => 'string',
                            'sub_section' => 'string',
                            'category' => 'string',
                            'price' => 'double',
                            'color' => 'string',
                            'material' => 'string',
                            'images' => 'array',
                            'options' => 'array',
                            'created_at' => 'string',
                            'updated_at' => 'string'

                        ]
                    ]
                ],

                [
                    'path' => '/products/new_in/{weeks?}/{section?}/{sub_section?}/{category?}',
                    'method' => 'GET',
                    'description' => 'Returns new products',
                    'args' => [

                        'weeks' => [
                            'required' => false,
                            'description' => 'number of weeks to go back from the current date',
                            'type' => 'integer'
                        ],

                        'section' => [
                            'required' => false,
                            'description' => 'Product section',
                            'type' => 'string'
                        ],

                        'sub_section' => [
                            'required' => false,
                            'description' => 'Product sub section',
                            'type' => 'string'
                        ],

                        'category' => [
                            'required' => false,
                            'description' => 'Product sub section',
                            'type' => 'string'
                        ],
                        'return_type' => 'array: json',                        
                        'return_data_structure' => [
                            [
                                'id' => 'integer',
                                'name' => 'srting',
                                'brand' => 'string',
                                'description' => 'string',
                                'section' => 'string',
                                'sub_section' => 'string',
                                'category' => 'string',
                                'price' => 'double',
                                'color' => 'string',
                                'material' => 'string',
                                'images' => 'array',
                                'options' => 'array',
                                'created_at' => 'string',
                                'updated_at' => 'string'
    
                            ]
                        ]
                    ]
                ],

                [
                    'path' => '/{id}',
                    'method' => 'GET',
                    'description' => 'returns product with the specified id',
                    'args' => [
                        'id' => [
                            'required' => true,
                            'description' => 'product id',
                            'type' => 'integer'
                        ]
                    ],
                    'return_type' => 'json',                    
                    'return_data_structure' => [
                        
                        'id' => 'integer',
                        'name' => 'srting',
                        'brand' => 'string',
                        'description' => 'string',
                        'section' => 'string',
                        'sub_section' => 'string',
                        'category' => 'string',
                        'price' => 'double',
                        'color' => 'string',
                        'material' => 'string',
                        'images' => 'array',
                        'options' => 'array',
                        'created_at' => 'string',
                        'updated_at' => 'string'

                        
                    ]
                ],

                [
                    'path' => '/search',
                    'method' => 'POST',
                    'description' => 'returns product that match the seach criteria',
                    'args' => [

                        'section' => [
                            'required' => true,
                            'description' => 'Product section',
                            'type' => 'string'
                        ],

                        'sub_section' => [
                            'required' => true,
                            'description' => 'Product sub section',
                            'type' => 'string'
                        ],

                        'category' => [
                            'required' => true,
                            'description' => 'Product sub section',
                            'type' => 'string'
                        ],

                        'color' => [
                            'required' => false,
                            'description' => 'Product color',
                            'type' => 'string'
                        ],

                        'material' => [
                            'required' => false,
                            'description' => 'Product material',
                            'type' => 'string'
                        ],

                        'min_price' => [
                            'required' => false,
                            'description' => 'Higher price limit',
                            'type' => 'double'
                        ],

                        'max_price' => [
                            'required' => false,
                            'description' => 'Lower price limit',
                            'type' => 'double'
                        ],

                        'brand' => [
                            'required' => false,
                            'description' => 'Product brand',
                            'type' => 'string'
                        ],

                        'name' => [
                            'required' => false,
                            'description' => 'Product name',
                            'type' => 'string'
                        ]
                    ],
                    'return_type' => 'array: json',                    
                    'return_data_structure' => [
                        [
                            'id' => 'integer',
                            'name' => 'srting',
                            'brand' => 'string',
                            'description' => 'string',
                            'section' => 'string',
                            'sub_section' => 'string',
                            'category' => 'string',
                            'price' => 'double',
                            'color' => 'string',
                            'material' => 'string',
                            'images' => 'array',
                            'options' => 'array',
                            'created_at' => 'string',
                            'updated_at' => 'string'

                        ]
                    ]
                ],


                //CREATE

                [
                    'path' => '/',
                    'method' => 'POST',
                    'description' => 'Add Product to database and returns details of the newly added product',
                    'args' => [

                        'name' => [
                            'required' => true,
                            'description' => 'Product name',
                            'type' => 'string'
                        ],

                        'brand' => [
                            'required' => true,
                            'description' => 'Product brand',
                            'type' => 'string'
                        ],

                        'description' => [
                            'required' => true,
                            'description' => 'Product description',
                            'type' => 'string'
                        ],

                        'section' => [
                            'required' => true,
                            'description' => 'Product section',
                            'type' => 'string'
                        ],

                        'sub_section' => [
                            'required' => true,
                            'description' => 'Product sub section',
                            'type' => 'string'
                        ],

                        'category' => [
                            'required' => true,
                            'description' => 'Product sub section',
                            'type' => 'string'
                        ],

                        'color' => [
                            'required' => true,
                            'description' => 'Product color',
                            'type' => 'string'
                        ],

                        'price' => [
                            'required' => true,
                            'description' => 'Product price',
                            'type' => 'double'
                        ],

                        'material' => [
                            'required' => true,
                            'description' => 'Product material',
                            'type' => 'string'
                        ],

                        'size_and_quantity' => [
                            'required' => true,
                            'description' => 'Array of product sizes and corresponding qunatity of each',
                            'type' => 'array: array[
                                "size" => string,
                                "quantity" => integer
                                ]'
                        ],

                        'image_one' => [
                            'required' => true,
                            'description' => 'Product image one',
                            'type' => '.png | .jpg | .gif'
                        ],

                        'image_two' => [
                            'required' => true,
                            'description' => 'Product image two',
                            'type' => '.png | .jpg | .gif'
                        ],

                        'image_three' => [
                            'required' => true,
                            'description' => 'Product image three',
                            'type' => '.png | .jpg | .gif'
                        ],
                    ],
                    'return_type' => 'json',                    
                    'return_data_structure' => [
                        'id' => 'integer',
                        'name' => 'srting',
                        'brand' => 'string',
                        'description' => 'string',
                        'section' => 'string',
                        'sub_section' => 'string',
                        'category' => 'string',
                        'price' => 'double',
                        'color' => 'string',
                        'material' => 'string',
                        'images' => 'array',
                        'options' => 'array',
                        'created_at' => 'string',
                        'updated_at' => 'string'
                    ]
                ],

                
                //UPDATE

                [
                    'path' => '/{id}',
                    'method' => 'PUT. NOTE: You have to use POST and then include a "_method: PUT" header',
                    'description' => 'Edit Product and return updated details of the edited product',
                    'args' => [

                        'id' => [
                            'required' => true,
                            'description' => 'id of product to edit',
                            'type' => 'integer'
                        ],

                        'name' => [
                            'required' => true,
                            'description' => 'Product name',
                            'type' => 'string'
                        ],

                        'brand' => [
                            'required' => true,
                            'description' => 'Product brand',
                            'type' => 'string'
                        ],

                        'description' => [
                            'required' => true,
                            'description' => 'Product description',
                            'type' => 'string'
                        ],

                        'section' => [
                            'required' => true,
                            'description' => 'Product section',
                            'type' => 'string'
                        ],

                        'sub_section' => [
                            'required' => true,
                            'description' => 'Product sub section',
                            'type' => 'string'
                        ],

                        'category' => [
                            'required' => true,
                            'description' => 'Product sub section',
                            'type' => 'string'
                        ],

                        'color' => [
                            'required' => true,
                            'description' => 'Product color',
                            'type' => 'string'
                        ],

                        'price' => [
                            'required' => true,
                            'description' => 'Product price',
                            'type' => 'double'
                        ],

                        'material' => [
                            'required' => true,
                            'description' => 'Product material',
                            'type' => 'string'
                        ],

                        'size_and_quantity' => [
                            'required' => true,
                            'description' => 'Array of product sizes and corresponding qunatity of each',
                            'type' => 'array: array[
                                "size" => string,
                                "quantity" => integer
                                ]'
                        ],
                        
                        'image_one' => [
                            'required' => true,
                            'description' => 'Product image one',
                            'type' => '.png | .jpg | .gif'
                        ],

                        'image_two' => [
                            'required' => true,
                            'description' => 'Product image two',
                            'type' => '.png | .jpg | .gif'
                        ],

                        'image_three' => [
                            'required' => true,
                            'description' => 'Product image three',
                            'type' => '.png | .jpg | .gif'
                        ],
                    ],
                    'return_type' => 'json',                    
                    'return_data_structure' => [
                        'id' => 'integer',
                        'name' => 'srting',
                        'brand' => 'string',
                        'description' => 'string',
                        'section' => 'string',
                        'sub_section' => 'string',
                        'category' => 'string',
                        'price' => 'double',
                        'color' => 'string',
                        'material' => 'string',
                        'images' => 'array',
                        'options' => 'array',
                        'created_at' => 'string',
                        'updated_at' => 'string'                       
                    ]
                ],


                //DELETE

                [
                    'path' => '/{id}',
                    'method' => 'DELETE',
                    'description' => 'delete product with specified id',
                    'args' => [
                        'id' => [
                            'required' => true,
                            'description' => 'Product id',
                            'type' => 'integer'
                        ]
                    ],
                    'return_type' => 'json',
                    'return_data_structure' => [
                        'message' => 'string'
                    ]

                ],

                [
                    'path' => '/mass_delete',
                    'method' => 'POST',
                    'description' => 'delete multiple products',
                    'args' => [
                        'ids' => [
                            'required' => true,
                            'description' => 'ids of products to delete',
                            'type' => 'arrray: string'
                        ]
                        ],
                        'return_type' => 'json',
                        'return_data_structure' => [
                            'message' => 'string'
                        ]
                ]


            ]


        ], 200);


    }


    /**
     * Returns products. Specific section, sub_section, and category of products may be requested
     * 
     * @param string $section Section string
     * @param string $sub_section Sub section string
     * @param string $category Category string
     * 
     * @return Response JSON formatted response
     */
    public function index($section=null, $sub_section=null, $category=null){

        $products= null;

        if($section){

            if($sub_section){

                if($category){

                    $products= Product::where( 'section', $section)
                                            ->where('sub_section', $sub_section)
                                            ->where('category', $category)
                                            ->get();
                          
                }
                else{
                    $products= Product::where( 'section', $section)
                                            ->where('sub_section', $sub_section)
                                            ->get();
                }

            }
            else{
                $products= Product::where( 'section', $section)->get();
            }

        }
        else{
            $products= Product::all();
        }


        return response()->json($products, 200);

    }

    /**
     * Returns products added within the specified number of weeks of the current date
     * 
     * @param int $weeks Number of weeks
     * @param string $section Section string
     * @param string $sub_section Sub section string
     * @param string $category Category string
     * 
     * @return Response JSON formatted response
     */
    public function new($weeks=3, $section=null, $sub_section=null, $category=null){

        $products= null;

        $min_date= Carbon::now()->subWeeks($weeks);

        if($section){

            if($sub_section){

                if($category){

                    $products= Product::where( 'section', $section)
                                            ->where('sub_section', $sub_section)
                                            ->where('category', $category)
                                            ->where('updated_at', '>=', $min_date)
                                            ->get();
                          
                }
                else{
                    $products= Product::where( 'section', $section)
                                            ->where('sub_section', $sub_section)
                                            ->where('updated_at', '>=', $min_date)
                                            ->get();
                }

            }
            else{
                $products= Product::where( 'section', $section)
                ->where('updated_at', '>=', $min_date)
                ->get();
            }

        }
        else{
            $products= Product::all()->where('updated_at', '>=', $min_date);
        }


        return response()->json($products, 200);

    }

    /**
     * Returns Product with specified id
     * 
     * @param int $id Product id
     * 
     * @return Response JSON formatted response
     */
    public function show($id){

        $product= Product::find($id);

        //if product is not found
        if(!$product){

            return response()->json([
                'error' => 'Product not found'
            ], 404);

        }

        return response()->json($product, 200);

    }

    /**
     * Return result of Product search
     * 
     * @param string $section
     * @param string $sub_section
     * @param string $category
     * @param string $color
     * @param double $min_price
     * @param double $max_price
     * @param string $brand
     * @param string $name
     * 
     * @return Response JSON formatted response of an array of matched products
     */
    public function search(Request $request){

        //VALIDATE SEARCH DATA
        $rules= [
            'name' => 'max:100|string',
            'brand' => 'max:100|string',
            'section' => 'max:100|string',
            'sub_section' => 'max:50|string',
            'category' => 'max:50|string',
            'min_price' => 'numeric',
            'max_price' => 'numeric',
            'color' => 'max:50|string',
            'material' => 'max:50|string'
        ];

        $request_validator= Validator::make($request->all(), $rules);

        //FAILED VALIDATION
        if($request_validator->fails()){
            return response()->json($request_validator->errors() ,401);
        }


        //SUCCESS VALIDATION

        $section= $request->get('section');
        $sub_section= $request->get('sub_section');
        $category= $request->get('category');

        $color= $request->get('color');
        //if no color is specified, set to empty string
        if(!$color)
            $color= '';

        $material= $request->get('material');
        //if no material is specified, set to empty string
        if(!$material)
            $material= '';

        $min_price= $request->get('min_price');
        //convert to double
        if($min_price){
            $min_price= doubleval($min_price);
        }
        else{
            $min_price= 0;
        }

        $max_price= $request->get('max_price');
        //convert to double
        if($max_price){
            $max_price= doubleval($max_price);
        }
        else{
            //set an impossibly high value for max_price so all products are selected
            $max_price= 1000000000;
        }


        $brand= $request->get('brand');
        //if no brand is specified, set to empty string
        if(!$brand)
            $brand= '';

        $name= $request->get('name');
        //if no name is specified, set to empty string
        if(!$name)
            $name= '';


        //CATEGORY ARRAY
        $category_array= [];

        if($section)
            $category_array['section']= $section;

        if($sub_section)
            $category_array['sub_section']= $sub_section;

        if($category)
            $category_array['category']= $category;


        //FIND MATCHED PRODUCTS
        $products= Product::where(
                        $category_array
                    )->where('name', 'like', '%'. $name . '%')
                    ->where('brand', 'like', '%' . $brand. '%')
                    ->where('color', 'like', '%' . $color . '%')                    
                    ->where('price', '>=', $min_price)
                    ->where('price', '<=', $max_price)
                    ->get();


        //if no result is found
        if(count($products) == 0){
            return response()->json([
                'error' => 'no matches found',
                'search_params' => $category_array
            ], 404);
        }

        return response()->json($products, 200);
    }



    /**
     * Add a new product to database
     * 
     * @param string $name
     * @param string $brand
     * @param string $description
     * @param string $section
     * @param string $sub_section
     * @param string $category
     * @param string $color
     * @param double $price
     * @param string $material
     * @param array $size_and_quantity
     * @param image $image_one  
     * @param image $image_two 
     * @param image $image_three
     * 
     * 
     * @return Response JSON formatted response with id and details of the newly added product
     */
    public function store(Request $request){

        //VALIDATION
        $rules= [
            'name' => 'required|max:100|string',
            'brand' => 'required|max:50|string',
            'description' => 'required|string',
            'section' => 'required|max:100|string',
            'sub_section' => 'required|max:50|string',
            'category' => 'required|max:50|string',
            'price' => 'required|numeric',
            'color' => 'required|max:50|string',
            'material' => 'required|max:50|string',
            'size_and_quantity' => 'required|JSON',
            'image_one' => 'required|mimes:jpeg,gif,png',
            'image_two' => 'required|mimes:jpeg,gif,png',
            'image_three' => 'required|mimes:jpeg,gif,png',
        ];

        $request_validator= Validator::make($request->all(), $rules);

        //FAILED VALIDATION
        if($request_validator->fails()){
            return response()->json($request_validator->errors(), 401);
        }


        //SUCCESS VALDATION

        //Validate "size_and_quantity" JSON array
        $size_and_quantity= json_decode($request->get('size_and_quantity'));
        $valid_size_and_quantity= false;

        foreach($size_and_quantity as $a_s_and_q){
            //check size string
            if( !isset($a_s_and_q->size) | !isset($a_s_and_q->quantity) ){
                //if 'size' OR 'quantity' attribute does not exist, set validity to false and exit loop
                $valid_size_and_quantity= false;
                break;
            }

            //if 'quanity' is a valid integer
            if ( filter_var($a_s_and_q->size, FILTER_SANITIZE_STRING) 
                    &&
                filter_var($a_s_and_q->quantity, FILTER_VALIDATE_INT) 
            )
            $valid_size_and_quantity= true;

        }


        //CHECK FOR 'size_and_quantity' VALIDATION
        if(!$valid_size_and_quantity){
            return response()->json( [
                'size_and_quantity' => 'A valid JSON array of objects with "size" and "quantity fileds is required"'
            ] ,401);
        }

        //GET PRODUCT IMAGES
        $image_one= $request->file('image_one')->store('products');
        $image_two= $request->file('image_two')->store('products');
        $image_three= $request->file('image_three')->store('products');

        //collect the paths of the images into an array
        $images= [$image_one, $image_two, $image_three];
        

        $new_product= new Product;

        $new_product->name= $request->get('name');
        $new_product->brand= $request->get('brand');
        $new_product->description= $request->get('description');
        $new_product->section= $request->get('section');
        $new_product->sub_section= $request->get('sub_section');
        $new_product->category= $request->get('category');
        $new_product->color= $request->get('color');
        $new_product->price= doubleval($request->get('price'));
        $new_product->material= $request->get('material');
        $new_product->size_and_quantity= $request->get('size_and_quantity');
        $new_product->images= json_encode($images);

        $new_product->save();    

        return response()->json([
            'message' => 'Product Added Successfully',
            'details' => $new_product
        ], 201);

        
    }


    /**
     * Update an existing product
     * 
     * @param int $id
     * @param string $name
     * @param string $brand
     * @param string $description
     * @param string $section
     * @param string $sub_section
     * @param string $category
     * @param string $color
     * @param double $price
     * @param string $material
     * @param array $size_and_quantity
     * @param image $image_one  
     * @param image $image_two 
     * @param image $image_three
     * 
     * @return Response JSON formatted response with id and details of the newly added product
     * 
     */
    public function update(Request $request, $id){

        //VALIDATION
        $rules= [
            'id' => 'digit',
            'name' => 'max:100|string',
            'brand' => 'max:50|string',
            'description' => 'string',
            'section' => 'max:100|string',
            'sub_section' => 'max:50|string',
            'category' => 'max:50|string',
            'price' => 'numeric',
            'color' => 'max:50|string',
            'material' => 'max:50|string',
            'size_and_quantity' => 'max:100|JSON',
            'image_one' => 'mimes:jpeg,gif,png',
            'image_two' => 'mimes:jpeg,gif,png',
            'image_three' => 'mimes:jpeg,gif,png',
        ];

        $request_validator= Validator::make($request->all(), $rules);

        //FAILED VALIDATION
        if($request_validator->fails()){
            return response()->json($request_validator->errors(), 401);
        }


        //SUCCESS VALDATION

        //CHECK IF PRODUCT ID IS VALID AND PULL THE PRODUCT FROM DATABASE
        $product= Product::find($id);

        //PRODUCT NOT FOUND
        if(!$product)
            return response()->json( [
                'error' => 'Product with id= ' . $request->id . ' not found'
            ] ,404);

        
        //UPDATE PRODUCT FIELDS IF NEW VALUES EXIST IN THE REQUEST

        //Name
        $buffer= $request->get('name');

        if($buffer){
            $product->name= $buffer;
        }

        //brand
        $buffer= $request->get('brand');

        if($buffer){
            $product->brand= $buffer;
        }

        //description
        $buffer= $request->get('description');

        if($buffer){
            $product->description= $buffer;
        }

        //section
        $buffer= $request->get('section');

        if($buffer){
            $product->section= $buffer;
        }

        //sub_section
        $buffer= $request->get('sub_section');

        if($buffer){
            $product->sub_section= $buffer;
        }

        //category
        $buffer= $request->get('category');

        if($buffer){
            $product->category= $buffer;
        }

        //color
        $buffer= $request->get('color');

        if($buffer){
            $product->color= $buffer;
        }

        //price
        $buffer= $request->get('price');

        if($buffer){
            $product->price= doubleval($buffer);
        }

        //material
        $buffer= $request->get('material');

        if($buffer){
            $product->material= $buffer;
        }

        //Validate "size_and_quantity" JSON array
        $buffer= $request->get('size_and_quantity');

        if($buffer){

            $valid_size_and_quantity= false;

            foreach($buffer as $a_s_and_q){
                //check size string
                if( !isset($a_s_and_q->size) | !isset($a_s_and_q->quantity) ){
                    //if 'size' OR 'quantity' attribute does not exist, set validity to false and exit loop
                    $valid_size_and_quantity= false;
                    break;
                }

                //if 'quanity' is a valid integer
                if (filter_var($a_s_and_q->quantity, FILTER_VALIDATE_INT))
                    $valid_size_and_quantity= true;

            }


            //CHECK FOR 'size_and_quantity' VALIDATION
            if(!$valid_size_and_quantity){
                return response()->json( [
                    'size_and_quantity' => 'A valid JSON array of objects with "size" and "quantity fileds is required"'
                ] ,401);
            }

            //IF VALID
            if($valid_size_and_quantity){
                $product->size_and_quantity= $buffer;
            }

        }

        //Images
        //Get current image JSON
        $images= json_decode($product->images);

        //image_one
        $buffer= $request->file('image_one');

        if($buffer){
            //save new image
            $new_image= $buffer->store('products');

            //delete existing image
            Storage::delete($images[0]);

            $images[0]= $new_image;
        }

        //image_two
        $buffer= $request->file('image_two');

        if($buffer){
            //save new image
            $new_image= $buffer->store('products');

            //delete existing image
            Storage::delete($images[1]);

            $images[1]= $new_image;
        }

        //image_three
        $buffer= $request->file('image_three');

        if($buffer){
            //save new image
            $new_image= $buffer->store('products');

            //delete existing image
            Storage::delete($images[2]);

            $images[2]= $new_image;
        }

        //Update product images
        $product->images= json_encode($images);


        //WRITE TO DATABASE
        $product->save();

        return response()->json( [
            'message' => 'Product updated sucessfully',
            'details' => $product
        ],200);

    }


    /**
     * Delete a product
     * 
     * @param int $id
     * 
     * @return Response JSON response
     */
    public function delete($id){

        //Pull product to delete
        $product= Product::find($id);

        //if product doesn't exist, return an error
        if(!$product){
            return response()->json( [
                'error' => "Product with id= " . $id . " not found"
            ], 404);
        }

        //Delete product
        $product->delete();

        return response()->json([], 204);

    }

    /**
     * Delete a product
     * 
     * @param int $ids
     * 
     * @return Response JSON response
     */
    public function massDelete(Request $request){

        //VALIDATION
        $rules= [
            'ids' => 'required|JSON'
        ];

        $request_validator= Validator::make($request->all(), $rules);

        //FAILED VALIDATION
        if($request_validator->fails()){
            return response()->json($request_validator->errors(), 404);
        }

        //Pull products to delete
        $ids= json_decode($request->get('ids'));

        $products= Product::find($ids);

        //if number of matched product does not equal number of passed ids, return an error
        if($products->count() != \count($ids)){

            //check for missing products
            $missing= [];
            
            foreach($ids as $id){

                if(!$products->find($id)){
                    \array_push($missing, $id);
                }
                
            }

            //return response with missing product ids
            return response()->json( [
                'error' => "Product(s) with ids= " . json_encode($missing) . " not found"
            ], 404);
        }

        
        //Delete products
        $errors= [];
        foreach($products as $product){

            //check for existing orders
            $orders= Order::where('product_id', $product->id)->get();

            if($orders->count() > 0){
                $errors[$product->id]= 'Could not delete! Product has existing orders';
                continue;
            }

            $product->delete();
        }

        //if errors
        if($errors){
            return response()->json( $errors ,401);
        }

        return response()->json([], 204);

    }

}
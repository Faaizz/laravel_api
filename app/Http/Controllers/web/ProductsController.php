<?php

namespace App\Http\Controllers\web;

use App\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
   
    /**
     * Return an array of male categories
     * 
     * @return json
     */
    function maleCategories(){

        $male_products= Product::where("sub_section", "male")->orWhere("sub_section", "unisex")->get();

        $male_product_categories= $male_products->map(function($product){
            return $product->category;
        });

        $male_product_categories= $male_product_categories->unique();

        return response()->json($male_product_categories);

    }


    /**
     * Return an array of male size
     * 
     * @return json
     */
    function maleSizes(){

        $male_products= Product::where("sub_section", "male")->orWhere("sub_section", "unisex")->get();

        $sizes_qty_array= [];

        $male_products->map(function($product) use (&$sizes_qty_array){

            $sizes_qty_array= \array_merge($sizes_qty_array, \json_decode($product->options, true));

        });

        // Loop through to get sizes only
        $sizes_array= [];

        foreach($sizes_qty_array as $size_qty){
            \array_push($sizes_array, $size_qty["size"]);
        }

        $sizes_collect= collect($sizes_array);

        $sizes_collect= $sizes_collect->unique();

        return response()->json($sizes_collect);

    }


    /**
     * Return male products. Optionally filter by category.
     * 
     * @param array $request->category: Embedded in query string
     * 
     * @return Illuminate\Support\Facades\View
     */
    function male(Request $request){

        $where_clause= '(sub_section LIKE "male" OR sub_section LIKE "unisex") AND (';

        // Check for filters
        // Check if category filter is active
        if($request->category != null){

            foreach($request->category as $key => $category){
                if($key == 0){
                    $where_clause= $where_clause . "category LIKE ?";
                }
                else{
                    $where_clause= $where_clause . " OR category LIKE ?";
                }
            }
   
            // Closing Parenthesis for where
            $where_clause= $where_clause . ")";

            //Parameters to inject
            $where_params= (\is_array($request->category)) ? $request->category : [$request->category];

            // Pull matched products
            $products= Product::whereRaw($where_clause, $where_params)->paginate();

            // Append category query string to generated pagination links
            $query_string= ["category" => $request->category];
            $products->appends($query_string);
            
            // Return requested products
            return view("multi_products", ["page_name"=> "Men's Clothing", "page_route"=> "male", "products"=> $products, "query_string"=> $query_string]);
        } 

        // No filters
        else{
            // Get all male products
            $products= Product::where("sub_section", "male")->paginate();

            return view("multi_products", ["page_name"=> "Men's Clothing", "page_route"=> "male", "products"=> $products]);
        }
    }


    /**
     * Return an array of female categories
     * 
     * @return json
     */
    function femaleCategories(){

        $female_products= Product::where("sub_section", "female")->get();

        $female_product_categories= $female_products->map(function($product){
            return $product->category;
        });

        $female_product_categories= $female_product_categories->unique();

        return response()->json($female_product_categories);


    }

    /**
     * Return an array of female sizes
     * 
     * @return json
     */
    function femaleSizes(){

        $female_products= Product::where("sub_section", "female")->get();

        $sizes_qty_array= [];

        $female_products->map(function($product) use (&$sizes_qty_array){

            $sizes_qty_array= \array_merge($sizes_qty_array, \json_decode($product->options, true));

        });

        // Loop through to get sizes only
        $sizes_array= [];

        foreach($sizes_qty_array as $size_qty){
            \array_push($sizes_array, $size_qty["size"]);
        }

        $sizes_collect= collect($sizes_array);

        $sizes_collect= $sizes_collect->unique();

        return response()->json($sizes_collect);

    }


    /**
     * Return female products that might be filtered by category or size.
     * 
     * @param array $request->category: Embedded in query string
     * 
     * @return Illuminate\Support\Facades\View
     */
    function female(Request $request){

        $where_clause= '(sub_section LIKE "female" OR sub_section LIKE "unisex") AND (';

        // Check for filters
        // Check if category filter is active
        if($request->category != null){

            foreach($request->category as $key => $category){
                if($key == 0){
                    $where_clause= $where_clause . "category LIKE ?";
                }
                else{
                    $where_clause= $where_clause . " OR category LIKE ?";
                }
            }
   
            // Closing Parenthesis for where
            $where_clause= $where_clause . ")";

            //Parameters to inject
            $where_params= (\is_array($request->category)) ? $request->category : [$request->category];

            // Pull matched products
            $products= Product::whereRaw($where_clause, $where_params)->paginate();

            // Append category query string to generated pagination links
            $query_string= ["category" => $request->category];
            $products->appends($query_string);
            
            // Return requested products
            return view("multi_products", ["page_name"=> "Women's Clothing", "page_route"=> "female", "products"=> $products, "query_string"=> $query_string]);
        } 

        // No filters
        else{
            // Get all female products
            $products= Product::where("sub_section", "female")->paginate();

            return view("multi_products", ["page_name"=> "Women's Clothing", "page_route"=> "female", "products"=> $products]);
        }
    }


    /**
     * Return single product
     * 
     * @param array $id: Route parameter
     * 
     * @return Illuminate\Support\Facades\View
     */
    public function single($id){

        // Find specified product
        $product= Product::find($id);

        // If product is not found, return 404 error
        if(!$product){
            abort(404);
        }

        // Get available product sizes and their corresponding
        $sizes= [];
        $options= collect(\json_decode($product->options, true))->each( function($item, $key) use (&$sizes){
            \array_push($sizes, $item["size"]);
        });
        // return response(\var_dump(\json_decode($product->options, true)));
        return view("single_product", ["page_name"=> $product->name, "product"=> $product]);


    }


}

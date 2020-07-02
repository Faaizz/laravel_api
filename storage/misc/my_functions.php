<?php


/**================================================================
 * FUNCTIONS DEFINED MY ME
 */
namespace Storage\Misc\Functions{

    function getTrendGender(){
        /**
         * Gives a "male" or "female" or 'unisex' string as gender
         * @return string
         */

        //gender array
        $gender= ["male", "female", "unisex"];
    
        //return a random selection of gender
        return $gender[rand(0,2)];
    }
    

    function getGender(){
        /**
         * Gives a "male" or "female" string as gender
         * @return string
         */
    
        //gender array
        $gender= ["male", "female"];
    
        //return a random selection of gender
        return $gender[rand(0,1)];
    }
    
    function getSection(){
        /**
         * Gives a section for the product
         * @return string
         */
    
        $sections= [
            'clothing',
            'shoes',
            'accessories',
            'bags & watches'
        ];
    
        return $sections[rand(0,3)];
    }
    
    function getCategory($section, $sub_section){
        /**
         * Gives a randomly selected category based on the supplied section and sub_section
         * @param section
         * @param sub_section
         * 
         * @return string
         */
    
         //variable to temporarily put an array of available categories
         $categories= [];
    
         switch($section){
    
            case "clothing":
                {
                    switch($sub_section){
                        case "male":
                            $categories= [
                                "T-Shirts",
                                "Shorts",
                                "Shirts",
                                "Trousers",
                                "Sweatshirts & Hoodies",
                                "Sweaters, Jackets, & Coats",
                                "Underwear"
                            ];
                            //"male" break
                            break;
    
                        case "female":
                            $categories= [
                                "Tops",
                                "Dresses",
                                "Skirts",
                                "Leggings & Vests",                               "Shorts",
                                "Shirts",
                                "Trousers",
                                "Sweatshirts & Hoodies",
                                "Sweaters, Jackets, & Coats",
                                "Underwear & Lingerie"
                            ];
                            //"female" break
                            break;
                    }
                }
                //"clothing break"
                break;
    
            case "shoes":
                {
                    switch($sub_section){
                        case "male":
                            $categories= [
                                "Oxford",
                                "Loafers",
                                "Sneakers",
                                "Boots",
                                "Snadals & Slippers"
                            ];
                            //"male" break
                            break;
    
                        case "female":
                            $categories= [
                                "Flats",
                                "Heels & Pumps",
                                "Sandals & Slippers",
                                "Sneakers",
                                "Boots"
                            ];
                            //"female" break
                            break;
                    }
                }
    
                //"shoes" break
                break;
            
            case "accessories":
                {
                    $categories= ["accessories"];
                }
                break;
    
            case "bags & watches":
                {
                    $categories= ["bags & watches"];
                }
                break;
                
            
    
         }
    
         $categories_count= \count($categories);
    
         return $categories[rand(0, ($categories_count-1) )];
    
    }

    /**
     * This function give a json array of randomly selected images of the format "section_1"- here the image number is "1"
     * @param section
     * @return json array
     */

    function getImages($section, $sub_section){

        switch($section){

            // FOR BAGS AND WATCHES

            case "bags & watches":
                {
                    $section= "bags_watches";
                    return json_encode( [$section."_".rand(1, 10).".jpeg", $section."_".rand(1, 10).".jpeg", $section."_".rand(1, 10).".jpeg"] );
                }
                break;

            // FOR ACCESSORIES

            case "accessories":
                {
                    $section= "accessories_male";
                    return json_encode( [$section."_".rand(1, 10).".jpeg", $section."_".rand(1, 10).".jpeg", $section."_".rand(1, 10).".jpeg"] );
                }
                break;

            // FOR ALL OTHER SECTIONS
    
            default:
                {
                    return json_encode( [$section."_".$sub_section."_".rand(1, 10).".jpeg", $section."_".$sub_section."_".rand(1, 10).".jpeg", $section."_".$sub_section."_".rand(1, 10).".jpeg"] );
                }  
                
            
    
         }

    }

    /**
     * This function gives a json array of sizes according to selected section
     * @param section
     * @return json array
     */
    function getOptions($section){

        $cloth_sizes= ["XS", "SM", "MD", "LG", "XL", "XXL"];

        switch($section){
    
            case "clothing":
                {
                    $size_one= $cloth_sizes[rand(0, (count($cloth_sizes)-1))];
                    $size_two= $cloth_sizes[rand(0, (count($cloth_sizes)-1))];

                    return json_encode([
                        [
                            "size" => $size_one,
                            "quantity" => rand(1, 20)
                        ],
                        [
                            "size" => $size_two,
                            "quantity" => rand(1, 20)
                        ]
                    ]);
                }
                //"clothing break"
                break;
    
            case "shoes":
                {
                    $size_one= rand(39, 45);
                    $size_two= rand(39, 45);

                    return json_encode([
                        [
                            "size" => $size_one,
                            "quantity" => rand(1, 20)
                        ],
                        [
                            "size" => $size_two,
                            "quantity" => rand(1, 20)
                        ]
                    ]);

                }
                //"shoes" break
                break;
            
            default:
                {
                    return json_encode([
                        [
                            "size" => "one size",
                            "quantity" => rand(1, 20)
                        ]
                    ]);
                }               
            
    
         }

    }


    /**
     * Removes product with the specified $product_id from the specified $json_list
     * @param json $json_list
     * @param int $product_id
     * 
     * @return json: Success
     * @return null: Failure
     */
    function removeProductFromList($json_list, $product_id){

        // Convert json into array of assoc arrays
        $array_list= \json_decode($json_list, true);

        // New array
        $new_array_list= [];

        // Sanity check
        if($product_id == null){
            return null;
        }

        // Iterate through the array in search of the product with specified id
        foreach ($array_list as $product_entry) {
            // Sanity check
            if($product_entry["id"] != null){
                // If product id doesn't match, add entry to new array
                if($product_entry["id"] != $product_id){
                    \array_push($new_array_list, $product_entry);
                }
            }
        }

        // Return the new array as a json result if product was found and removed
        if(\count($array_list) !== \count($new_array_list)){
            return \json_encode($new_array_list);
        }
        // Otherwise, return null
        else{
            return null;
        }


    }


    /**
     * Adds specified $product_entry to $json_list
     * @param json $json_list
     * @param array (id, size, quantity) $product_entry
     * 
     * @return json: Success
     * @return false: Product already in list
     */
    function addProductToList($json_list, $new_product){

        // Convert json list to array of assoc arrays
        $array_list= \json_decode($json_list, true);

        // Sanity check
        if($new_product["id"] == null){
            return null;
        }

        $matched= false;

        // Iterate through the array in search of the product with specified id
        foreach ($array_list as $product_entry) {
            // Sanity check
            if($product_entry["id"] != null){
                // If product matches, set $matched
                if($product_entry["id"] == $new_product["id"]){
                    $matched= true;
                }
            }
        }

        // If product already exists in list, return false
        if($matched){
            return false;
        }


        // Otherwise, add product to list
        \array_push($array_list, $new_product);

        return \json_encode($array_list);

    }

    /**
     * Changes the quantity of specified product in $json_list
     * @param json $json_list
     * @param int $product_id
     * @param int $quantity
     * 
     * @return json: Success
     * @return null: Failure
     */
    function editProductInList($json_list, $product_id, $quantity){

        // Convert json list to array of assoc arrays
        $array_list= \json_decode($json_list, true);

        // New array
        $new_array_list= [];


        $matched= false;

        // Iterate through the array in search of the product with specified id
        foreach ($array_list as $product_entry) {
            // Sanity check
            if($product_entry["id"] != null){
                // If product matches
                if($product_entry["id"] == $product_id){
                    // set $matched
                    $matched= true;
                    // insert new quantity
                    $product_entry["quantity"]= $quantity;
                }

                \array_push($new_array_list, $product_entry);
            }
        }

        // If product is not found, return null
        if(!$matched){
            return null;
        }


        // Otherwise, return new list with product quantity changed
        return \json_encode($new_array_list);

    }
    
}


?>
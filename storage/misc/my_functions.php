<?php


/**================================================================
 * FUNCTIONS DEFINED MY ME
 */
namespace Storage\Misc\Functions{

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
    
}


?>
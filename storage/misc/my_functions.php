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
    
}


?>
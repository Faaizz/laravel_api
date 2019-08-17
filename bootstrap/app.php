<?php

/**================================================================
 * FUNCTIONS DEFINED MY ME
 */
namespace Misc\Functions{

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

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

//  R   E   T   U   R   N       T   O       G   L   O   B   A   L       N   A   M   E   S   P   A   C   E

namespace{

$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/



return $app;

}
<?php

namespace Utility;

use App\Staff;

use Illuminate\Support\Facades\Auth;

class AuthenticateStaff{

    protected $valid_staff= false;

    function __construct(){

        //Validate Staff Authentication
        //If a staff is signed in
        if( Auth::guard('staffs')->check() ){

            $valid_staff= true;

        }

    }

    public function fails(){

        //If no valid staff is logged in
        if(!$valid_staff){

            return true;

        }
        //Otherwise
        else{
            return false;
        }

    }

    public function errors(){

        //Return a Response with authentication Error
        return response()->json( [
            "failed_authentication" => "Please login." 
        ], 401);

    }

}

?>
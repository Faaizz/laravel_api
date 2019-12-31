<?php

namespace Utility;

use Illuminate\Http\Request;

use App\Customer;
use  App\Http\Controllers\CustomerController;

use Illuminate\Support\Facades\Auth;

class AuthenticateCustomer {

    protected $valid_customer= false;

    function __construct(Request $request){

        //Pull "X-REMEMBER" cookie from request
        $remember_cookie= $request->cookie('X-REMEMBER-CUSTOMER');

        //Validate Staff Authentication
        //If a staff is signed in
        if( Auth::guard('web')->check() ){

            $this->valid_customer= true;

        }
        //Try Login with X-REMEMBER token
        else if($remember_cookie){

            $login_attempt= CustomerController::cookie_login_facilitator($remember_cookie);

            //SUCCESS
            if($login_attempt){

                $this->valid_customer= true;

            }

        }

    }

    public function fails(){

        //If no valid staff is logged in
        if(!$this->valid_customer){

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
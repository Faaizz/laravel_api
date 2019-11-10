<?php

namespace Utility;

use Illuminate\Http\Request;

use App\Staff;
use  App\Http\Controllers\StaffController;

use Illuminate\Support\Facades\Auth;

class AuthenticateStaff{

    protected $valid_staff= false;

    function __construct(Request $request){

        //Pull "X-REMEMBER" cookie from request
        $remember_cookie= $request->cookie('X-REMEMBER');

        //Validate Staff Authentication
        //If a staff is signed in
        if( Auth::guard('staffs')->check() ){

            $this->valid_staff= true;

        }
        //Try Login with X-REMEMBER token
        else if($remember_cookie){

            $login_attempt= StaffController::cookie_login_facilitator($remember_cookie);

            //SUCCESS
            if($login_attempt){

                $this->valid_staff= true;

            }

        }


    }

    public function fails(){

        //If no valid staff is logged in
        if(!$this->valid_staff){

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
            "failed_authentication" => "Please login as a staff." 
        ], 401);

    }

}

?>
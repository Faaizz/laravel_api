<?php

namespace Utility;

use App\Staff;

use Illuminate\Support\Facades\Auth;

class AuthorizeAdmin extends AuthenticateStaff{

    //$valid_staff inherited from AuthenticateStaff class
    protected $valid_admin= false;

    function __construct(){

        //Call AuthenticateStaff contructor to validate staff login
        parent::__construct();

        //If staff is logged in
        if( $this->valid_staff ){

            //Check if she's admin
            $staff= Auth::guard('staffs')->user();

            //If yes, set $valid_admin to true
            if( $staff->isAdmin() ){
                $this->valid_admin= true;
            }
        }
        
    }

    public function fails(){

        //If no staff is logged in or Staff is not admin, return true
        if( !$this->valid_staff || !$this->valid_admin ){
            return true;
        }
        //Otherwise, return false
        else{
            return false;
        }

    }

    public function errors(){

        //If no staff is logged in, call parent errors() method
        if( !$this->valid_staff ){
            return parent::errors();
        }

        //If a staff is loggedin but is not admin
        return response()->json( [
            "failed_authorization" => "Please login as admin." 
        ], 401);

    }

}


?>
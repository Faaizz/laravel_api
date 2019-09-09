<?php

namespace Utility;


use App\Customer;
use App\Staff;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;



class SimulateLogin{

    /**
     * Simulate Customer Login
     */
    public static function customer(){

        //Login the last customer
        $customer= Customer::find('brown29@example.net');

        if( !$customer ){
            $customer= Customer::all()->last();
        }

        Auth::guard('web')->login($customer);

    }

    /**
     * Simulate Staff Login
     */
    public static function staff(){

        //Login the last Staff
        $staff= Staff::find('aishayetunde');

        if( !$staff ){
            $staff= Staff::all()->last();
        }

        Auth::guard('staffs')->login($staff);

    }

    /**
     * Simulate Admin Login
     */
    public static function admin(){

        //Login the last Staff
        $staff= Staff::where('privilege_level', 'admin')->first();
        Auth::guard('staffs')->login($staff);

    }

}


?>
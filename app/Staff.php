<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Staff extends Authenticatable
{
    protected $table= 'staffs';
    protected $primaryKey= 'email';
    protected $keyType= 'string';

    protected $hidden= [
        'remember_token'
    ];

    public function isAdmin(){

        if( $this->privilege_level == "admin"){
            return true;
        }
        else{
            return false;
        }

    }

    //Relationship with Orders
    public function orders(){

        return $this->hasMany('App\Order');
        
    }
}

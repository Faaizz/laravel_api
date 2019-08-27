<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Staff extends Authenticatable
{
    protected $table= 'staffs';
    protected $primaryKey= 'email';
    protected $keyType= 'stirng';

    protected $hidden= [
        'remember_token'
    ];

    //Relationship with Orders
    public function orders(){
        return $this->hasMany('App\Order');
    }
}

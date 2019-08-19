<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    //Relationship with Orders
    public function orders(){
        return $this->hasMany('App\Order');
    }
    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //Foreign Key relationship with product
    public function product(){
        return $this->hasOne('App\Product');
    }

    //Foreign Key relationship with customer
    public function customer(){
        return $this->hasOne('App\Customer');
    }
    
}

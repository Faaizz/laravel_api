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

    //Return failed orders
    public function isFailed(){

        if ($this->status == "failed"){
            return true;
        }
        else {
            return false;
        }

    }

    //Return delivered orders
    public function isDelivered(){

        if ($this->status == "delivered"){
            return true;
        }
        else {
            return false;
        }

    }

    //Return pending orders
    public function isPending(){

        if ($this->status == "pending"){
            return true;
        }
        else {
            return false;
        }

    }
    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    
    //Relationship with Orders
    public function orders(){
        return $this->hasMany('App\Order');
    }
    
    //Relationship with Trends (many-to-many)
    public function trends(){
        return $this->belongsToMany('App\Trend', 'product_trend', 'product_id', 'trend_id');
    }

}

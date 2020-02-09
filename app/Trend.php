<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trend extends Model
{
    /**
     * Relationship with Products (many-to-many)
     */
    public function products(){
        return $this->belongsToMany('App\Product', 'product_trend', 'trend_id', 'product_id');
    }


    /**
     * Check that Trend is a male (or unisex)
     */
    public function male(){

        if( ($this->gender == 'male') || ($this->gender == 'unisex') ){
            return true;
        }
        else{
            return false;
        }

    }

    /**
     * Check that Trend is a female (or unisex)
     */
    public function female(){

        if( ($this->gender == 'female') || ($this->gender == 'unisex') ){
            return true;
        }
        else{
            return false;
        }

    }

}

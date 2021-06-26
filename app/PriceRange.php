<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceRange extends Model
{
    protected $table = 'price_ranges';


    /***********************************************************************/
    /**************************** Relationships ****************************/
    /***********************************************************************/

    public function business()
    {
        return $this->hasMany(Business::class,'price_range_id','id');
    }

    /************************************************************************/
    /***************************** Attributes *******************************/
    /************************************************************************/

    public function getDisplayNameAttribute()
    {
        return "{$this-> name} - {$this-> symbol}";
    }



}

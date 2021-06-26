<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'districts';


    /***********************************************************************/
    /**************************** Relationships ****************************/
    /***********************************************************************/

    public function province()
    {
        return $this->belongsTo(Province::class,'province_id','id');
    }

    public function businesses()
    {
        return $this->hasMany(Business::class,'district_id','id');
    }
}

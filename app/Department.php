<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';

    /***********************************************************************/
    /**************************** Relationships ****************************/
    /***********************************************************************/

    public function provinces()
    {
        return $this->hasMany(Province::class,'department_id','id');
    }

    public function shippings()
    {
        return $this->morphMany(Shipping::class, 'shippingable');
    }
}

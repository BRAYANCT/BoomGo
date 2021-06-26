<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'provinces';

    /***********************************************************************/
    /**************************** Relationships ****************************/
    /***********************************************************************/

    public function department()
    {
        return $this->belongsTo(Department::class,'department_id','id');
    }

    public function districts()
    {
        return $this->hasMany(District::class,'province_id','id');
    }

    public function businesses()
    {
        return $this->hasManyThrough(Business::class, District::class);
    }



}

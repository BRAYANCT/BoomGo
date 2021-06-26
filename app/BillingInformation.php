<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillingInformation extends Model
{
    protected $table = 'billing_information';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'district_id','names','surnames','email','phone','address'
    ];

    /***********************************************************************/
    /**************************** Relationships ****************************/
    /***********************************************************************/

    public function district()
    {
        return $this->belongsTo(District::class,'district_id','id');
    }

    public function orderGroup()
    {
        return $this->hasOne(OrderGroup::class, 'billing_information_id', 'id');
    }

    /************************************************************************/
    /***************************** Attributes *******************************/
    /************************************************************************/

    /***********************************************************************/
    /**************************** Functions ********************************/
    /***********************************************************************/

}

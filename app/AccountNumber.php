<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountNumber extends Model
{
    protected $table = 'account_numbers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'business_payment_method_id',
        'name',
        'name_bank',
        'account_number',
        'cci',
    ];

    public $timestamps = false;

    /***********************************************************************/
    /**************************** Relationships ****************************/
    /***********************************************************************/

    public function businessPaymentMethod()
    {
        return $this->belongsTo(BusinessPaymentMethod::class,'business_payment_method_id','id');
    }

}

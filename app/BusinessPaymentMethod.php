<?php

namespace App;

use App\Traits\Models\Auditable;
use Illuminate\Database\Eloquent\Model;

class BusinessPaymentMethod extends Model
{
    use Auditable;

    protected $table = 'business_payment_method';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payment_method_id',
        'business_id',

        'access_token',
        'public_key',
        'client_id',
        'refresh_token',
        'date_expire_token',

        'client_secret',
        'sandbox',
        'test_access_token',
        'test_public_key',

        'description',
        'instructions',
    ];

    protected $casts = [
        'sandbox' => 'boolean',
    ];

    /***********************************************************************/
    /**************************** Relationships ****************************/
    /***********************************************************************/

    public function accountNumbers()
    {
        return $this->hasMany(AccountNumber::class,'business_payment_method_id','id');
    }

}

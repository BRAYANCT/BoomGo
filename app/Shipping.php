<?php

namespace App;

use App\Traits\Models\Auditable;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use Auditable;

    protected $table = 'shippings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'business_id',
        'shippingable_id',
        'shippingable_type',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    /***********************************************************************/
    /**************************** Relationships ****************************/
    /***********************************************************************/

    public function business()
    {
        return $this->belongsTo(Business::class,'business_id','id');
    }

    public function shippingable()
    {
        return $this->morphTo('shippingable');
    }

    /************************************************************************/
    /***************************** Attributes *******************************/
    /************************************************************************/

    public function getShippingTypeNameAttribute()
    {
        $shippingTypeName = "";

        if($this->shippingable_type == Department::class){
            $shippingTypeName = "Departamento";
        }else if($this->shippingable_type == Province::class){
            $shippingTypeName = "Provincia";
        }else if($this->shippingable_type == District::class){
            $shippingTypeName = "Distrito";
        }
        return $shippingTypeName;
    }

    public function getShippingTypeAttribute()
    {
        $shippingTypeName = "";

        if($this->shippingable_type == Department::class){
            $shippingTypeName = "department";
        }else if($this->shippingable_type == Province::class){
            $shippingTypeName = "province";
        }else if($this->shippingable_type == District::class){
            $shippingTypeName = "district";
        }
        return $shippingTypeName;
    }

}

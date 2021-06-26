<?php

namespace App;

use App\Helpers\NumberHelper;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'itemable_id','itemable_type','product_id','name','price','offer_price','quantity'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'offer_price' => 'decimal:2',
    ];

    /***********************************************************************/
    /**************************** Relationships ****************************/
    /***********************************************************************/

    public function itemable()
    {
        return $this->morphTo('itemable');
    }


    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }

    /************************************************************************/
    /***************************** Attributes *******************************/
    /************************************************************************/

    public function getSubTotalAttribute()
    {
        return NumberHelper::formatDefault($this-> final_price * $this-> quantity);
    }

    public function getTotalAttribute()
    {
        return $this->sub_total;
    }

    public function getNameAttribute()
    {
        if($this->itemable_type == ShoppingCart::class){
            return $this->product->name;
        }else{
            return $this->attributes['name'];
        }
    }

    public function getPriceAttribute()
    {
        if($this->itemable_type == ShoppingCart::class){
            return $this->product->price;
        }else{
            return $this->attributes['price'];
        }
    }

    /**
     * Precio teniendo en cuenta la oferta
     *
     * @return float
     */
    public function getOfferPriceAttribute()
    {
        if($this->itemable_type == ShoppingCart::class){
            return $this->product->offer_price;
        }else{
            return $this->attributes['offer_price'];
        }
    }

    public function getOfferActiveAttribute()
    {
        if($this->itemable_type == ShoppingCart::class){
            return $this->product->offer_active;
        }else{
            return $this->offer_price ? $this->offer_price > 0 : false;
        }
    }

    /**
     * Precio teniendo en cuenta la oferta
     *
     * @return float
     */
    public function getFinalPriceAttribute()
    {
        if($this->itemable_type == ShoppingCart::class){
            return $this->product->final_price;
        }else{
            if($this->offer_active){
                return NumberHelper::formatDefault($this->offer_price);
            }else{
                return NumberHelper::formatDefault($this->price) ;
            }
        }
    }

}

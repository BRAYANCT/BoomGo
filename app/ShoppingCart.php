<?php

namespace App;

use App\Helpers\NumberHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    protected $table = 'shopping_carts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'cookie_token',
    ];

    /***********************************************************************/
    /**************************** Relationships ****************************/
    /***********************************************************************/

    public function items()
    {
        return $this->morphMany(Item::class, 'itemable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /************************************************************************/
    /***************************** Attributes *******************************/
    /************************************************************************/

    public function getDisplayDateCreatedAtAttribute()
    {
        if(!empty($this-> created_at)){
            return Carbon::parse($this-> created_at)->format('d/m/Y');
        }
    }

    public function getDisplayCreatedAtAttribute()
    {
        if(!empty($this-> created_at)){
            return Carbon::parse($this-> created_at)->format('d/m/Y H:i');
        }
    }


    public function getTotalAttribute()
    {
        $total = 0.00;
        foreach ($this-> items as $key => $item) {
            $total += $item-> final_price * $item-> quantity;
        }
        return NumberHelper::formatDefault($total);
    }

    public function getTotalQuantityAttribute()
    {
        $quantity = 0;
        foreach ($this->items as $key => $item) {
            $quantity += $item-> quantity;
        }
        return $quantity;
    }

}

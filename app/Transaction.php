<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id','external_reference','total_amount',
    ];


    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}

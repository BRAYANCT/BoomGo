<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'payment_methods';

    /***********************************************************************/
    /**************************** Relationships ****************************/
    /***********************************************************************/

    public function orders()
    {
        return $this->hasMany(Order::class,'payment_method_id','id');
    }

    public function businesses()
    {
        return $this->belongsToMany(Business::class);
    }

    /***********************************************************************/
    /**************************** Functions ********************************/
    /***********************************************************************/

    /**
     * Verifica si el metodo de pago es mercado de pago
     *
     * @param
     * @return boolean
     */
    public function isMercadoPago()
    {
        return $this -> id == config('constant.paymentmethod.mercadopago.id');
    }

    /**
     * Verifica si el metodo de pago es pago contra entrega
     *
     * @param
     * @return boolean
     */
    public function isUponDelivery()
    {
        return $this -> id == config('constant.paymentmethod.upon_delivery.id');
    }

    /**
     * Verifica si el metodo de pago es transferencia bancaria
     *
     * @param
     * @return boolean
     */
    public function isWireTransfer()
    {
        return $this -> id == config('constant.paymentmethod.wire_transfer.id');
    }

}

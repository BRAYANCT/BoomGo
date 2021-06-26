<?php

namespace App;

use App\Helpers\NumberHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_group_id','business_id','order_state_id','shipping_price','order_code_payment_method'
    ];

    protected $casts = [
        'shipping_price' => 'decimal:2',
    ];


    /***********************************************************************/
    /**************************** Relationships ****************************/
    /***********************************************************************/

    public function orderState()
    {
        return $this->belongsTo(OrderState::class,'order_state_id','id');
    }

    public function business()
    {
        return $this->belongsTo(Business::class,'business_id','id');
    }

    public function items()
    {
        return $this->morphMany(Item::class, 'itemable');
    }

    public function orderGroup()
    {
        return $this->belongsTo(OrderGroup::class,'order_group_id','id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class,'order_id','id');
    }


    /**
     * Get the user's history.
     */
    public function user()
    {
        return $this->hasOneThrough(
            User::class,
            OrderGroup::class,
            'id', // Foreign key on users table...
            'id', // Foreign key on history table...
            'order_group_id', // Local key on suppliers table...
            'user_id' // Local key on users table...
        );
    }


    public function billingInformation()
    {
        return $this->hasOneThrough(
            BillingInformation::class,
            OrderGroup::class,
            'id', // Foreign key on billing information table...
            'id', // Foreign key on order group...
            'order_group_id', // Local key on suppliers table...
            'billing_information_id' // Local key on billing information table...
        );
    }

    public function paymentMethod()
    {
        return $this->hasOneThrough(
            PaymentMethod::class,
            OrderGroup::class,
            'id', // Foreign key on payment method table...
            'id', // Foreign key on order group...
            'order_group_id', // Local key on order gorup table...
            'payment_method_id' // Local key on payment_method table...
        );
    }

    /************************************************************************/
    /***************************** Attributes *******************************/
    /************************************************************************/

    public function getDisplayCreatedAtAttribute()
    {
        if(!empty($this-> created_at)){
            return Carbon::parse($this-> created_at)->format('d/m/Y H:i');
        }
    }

    public function getDisplayDateCreatedAtAttribute()
    {
        if(!empty($this-> created_at)){
            return Carbon::parse($this-> created_at)->format('d/m/Y');
        }
    }

    public function getDisplayHourCreatedAtAttribute()
    {
        if(!empty($this-> created_at)){
            return Carbon::parse($this-> created_at)->format('H:i');
        }
    }

    /**
     * Obtiene el precio sin los impuestos ni envio
     *
     */
    public function getSubTotalAttribute()
    {
        $subTotal = 0.00;
        foreach ($this-> items as $key => $item) {
            $subTotal += $item-> final_price * $item-> quantity;
        }
        return NumberHelper::formatDefault($subTotal);
    }

    /**
     * Obtiene el precio total de la orden incluido envios e impuestos
     *
     */
    public function getTotalAttribute()
    {
        $total = $this->shipping_price + $this->sub_total;
        return NumberHelper::formatDefault($total);
    }

    /**
     * Obtiene la cantidad total de items del pedido
     *
     */
    public function getQuantityTotalAttribute()
    {
        $quantity = 0;
        foreach ($this->items as $key => $item) {
            $quantity += $item-> quantity;
        }
        return $quantity;
    }

    public function getCodeAttribute()
    {
        return $this->getCode();
    }

    /***********************************************************************/
    /**************************** Functions ********************************/
    /***********************************************************************/

    /**
     * Obtiene el metodo de pago del negocio
     *
     * @return boolean
     */
    public function getBusinessPaymentMethod()
    {
        return BusinessPaymentMethod::where('business_id',$this->business_id)
            ->where('payment_method_id',$this->paymentMethod->id)
            ->first();
    }

    /**
     * Verifica si a la orden existente se le puede realizar pagos
     *
     * @return boolean
     */
    public function allowsPayments()
    {
        if($this-> paymentMethod-> isMercadoPago() && $this-> orderState-> allowsPayments()){
            return true;
        }
        return false;
    }

    /**
     * obtiene el codigo del pedido
     *
     * @return Boolean
     */
    public function getCode()
    {
        $numberDigits = strlen($this-> id);
        $minCodeDigits = 3;

        $code = "O-";

        // agrega los 0
        if($numberDigits < $minCodeDigits){
            for ($i=0; $i < $minCodeDigits-$numberDigits ; $i++) {
                $code .= "0";
            }
        }
        return $code.$this-> id;
    }


    /**
     * Verifica si la orden puede cambiar a pagado
     *
     * @return Boolean
     */
    public function canChangeToPaidOut()
    {
        if($this-> paymentMethod-> isUponDelivery() && $this-> orderState->isOutstanding() ){
            return true;
        }
        return false;
    }


    /**
     * Verifica si la orden puede cambiar a entregado
     *
     * @return Boolean
     */
    public function canChangeToDelivered()
    {
        // si es contraentrega
        if($this-> paymentMethod-> isUponDelivery()){
            return $this-> orderState->isOutstanding() || $this-> orderState->isPaidOut();
        }else if($this-> paymentMethod-> isMercadoPago()){
            return $this-> orderState->isPaidOut();
        }
        return false;
    }

    /**
     * Verifica si la orden puede cambiar a cancelado
     *
     * @return Boolean
     */
    public function canChangeToCancelled()
    {
        if($this-> paymentMethod-> isUponDelivery()){
            return $this-> orderState->isOutstanding();
        }
        return false;
    }

    /**
     * Verifica si la orden puede cambiar a pago fallido o erroneo
     *
     * @return Boolean
     */
    public function canChangeToFailedPayment()
    {
        return $this-> paymentMethod-> isMercadoPago() && $this-> orderState->isOutstanding();
    }


}

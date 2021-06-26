<?php

namespace App;

use App\Helpers\NumberHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class OrderGroup extends Model
{

    use Notifiable;

    protected $table = 'order_groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','billing_information_id','payment_method_id'
    ];


    /***********************************************************************/
    /**************************** Relationships ****************************/
    /***********************************************************************/

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class,'payment_method_id','id');
    }

    public function billingInformation()
    {
        return $this->belongsTo(BillingInformation::class, 'billing_information_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class,'order_group_id','id');
    }

    /************************************************************************/
    /***************************** Attributes *******************************/
    /************************************************************************/

    public function getCodeAttribute()
    {
        return $this->getCode();
    }

    /**
     * Obtiene el precio sin los impuestos ni envio
     *
     */
    public function getSubTotalAttribute()
    {
        $subTotal = 0.00;
        foreach ($this-> orders as $key => $order) {
            $subTotal += $order-> sub_total;
        }
        return NumberHelper::formatDefault($subTotal);
    }

    /**
     * Obtiene el precio total de la orden incluido envios e impuestos
     *
     */
    public function getTotalAttribute()
    {
        $total = 0.00;
        foreach ($this-> orders as $key => $order) {
            $total += $order-> total;
        }
        return NumberHelper::formatDefault($total);
    }
    /**
     * Obtiene la cantidad total de items de los pedidos agrupados
     *
     */
    public function getQuantityTotalAttribute()
    {
        $quantity = 0;
        foreach ($this->orders as $key => $order) {
            $quantity += $order-> quantity_total;
        }
        return $quantity;
    }

    /***********************************************************************/
    /**************************** Functions ********************************/
    /***********************************************************************/

    public function routeNotificationForMail()
    {
        if(config('app.mail_debug')){
            return config('app.email_debug');
        }
        return $this-> user-> email;
    }

    /**
     * Genere el codigo del pedido grupo
     *
     * @return Boolean
     */
    public function getCode()
    {
        $numberDigits = strlen($this-> id);
        $minCodeDigits = 3;

        $code = "G-";

        // agrega los 0
        if($numberDigits < $minCodeDigits){
            for ($i=0; $i < $minCodeDigits-$numberDigits ; $i++) {
                $code .= "0";
            }
        }
        return $code.$this-> id;
    }

}

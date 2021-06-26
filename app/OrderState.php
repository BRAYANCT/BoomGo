<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderState extends Model
{
    protected $table = 'order_states';


    /***********************************************************************/
    /**************************** Relationships ****************************/
    /***********************************************************************/

    public function orders()
    {
        return $this->hasMany(Order::class,'order_state_id','id');
    }

    /************************************************************************/
    /***************************** Attributes *******************************/
    /************************************************************************/


    public function getBadgeAttribute()
    {
//        return '<span class="badge badge-pill bg-'.$this-> html_class.' py-2 px-3">'.$this->name.'</span>';

        $classHtml = "";

        if($this->isOutstanding()){
            $classHtml = "primary";
        }else if($this->isPaidOut()){
            $classHtml = "warning";
        }else if($this->isDelivered()){
            $classHtml = "success";
        }else if($this->isFailedPayment()){
            $classHtml = "danger";
        }else if($this->isCancelled()){
            $classHtml = "danger";
        }

        return '<span class="badge badge-pill bg-'.$classHtml.' py-2 px-3">'.$this->name.'</span>';
    }


    /***********************************************************************/
    /**************************** Functions ********************************/
    /***********************************************************************/

    /**
     * Verifica si el estado de la orden permite realizar un pago
     *
     * @return boolean
     */
    public function allowsPayments()
    {
        if($this->isOutstanding() || $this->isFailedPayment()){
            return true;
        }
        return false;
    }

    /**
     * Se encuentra pendiende de pago
     *
     * @return boolean
     */
    public function isOutstanding()
    {
        return $this -> id == config('constant.orderstate.OUTSTANDING_ID');
    }

    /**
     * Se encuentra pagado
     *
     * @return boolean
     */
    public function isPaidOut()
    {
        return $this -> id == config('constant.orderstate.PAID_OUT_ID');
    }

    /**
     * Se encuentra entregado
     *
     * @return boolean
     */
    public function isDelivered()
    {
        return $this -> id == config('constant.orderstate.DELIVERED_ID');
    }

    /**
     * Se encuentra en pago fallido
     *
     * @return boolean
     */
    public function isFailedPayment()
    {
        return $this -> id == config('constant.orderstate.FAILED_PAYMENT_ID');
    }

    /**
     * Se encuentra en estado cancelado
     *
     * @return boolean
     */
    public function isCancelled()
    {
        return $this -> id == config('constant.orderstate.CANCELLED_ID');
    }



}

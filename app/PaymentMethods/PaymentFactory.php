<?php

namespace App\PaymentMethods;

use App\Order;
use App\PaymentMethods\MercadoPago;
use App\PaymentMethods\Yape;
use Illuminate\Http\Request;


class PaymentFactory
{

    public $paymentMethod;

    public function __construct($paymentMethodId)
    {
        switch ($paymentMethodId) {
            case config('constant.paymentmethod.mercadopago.id');
              $this-> paymentMethod = new MercadoPago();
              break;
            case config('constant.paymentmethod.upon_delivery.id');
                $this-> paymentMethod = new UponDelivery();
                break;
        }
    }



}

<?php


namespace App\PaymentMethods;


use App\Order;

class UponDelivery implements IPayment
{

    /**
     * Genera el metodo de pago y retorna el url
     *
     * @param Order $order
     * @return String
     */
    public function setUpPaymentAndGetRedirectURL(Order $order): string
    {
        return route('checkout.thanks',$order);
    }

    /**
     * Guarda la informacion en la base de datos referente al pago
     *
     * @param Order $order
     * @param array $data datos que envia la plataforma de pagos
     * @return Boolean
     */
    public function updateDataPaymentMethod(Order $order, $data)
    {
        throw new \Exception('Method updateDataPaymentMethod() is not implemented.');
    }

    /**
     * Cambia la orden a pago fallido
     *
     * @param Order $order
     * @param array $data datos que envia la plataforma de pagos
     * @return Boolean
     */
    public function changeToFailedPayment(Order $order, $data)
    {
        throw new \Exception('Method changeToFailedPayment() is not implemented.');
    }
}

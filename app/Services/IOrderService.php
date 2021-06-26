<?php


namespace App\Services;


use App\Order;

interface IOrderService
{
    /**
     * Cambia la orden a estado pago fallido.
     *
     * @param Order $order
     * @return Boolean
     * @throws \Exception
     */
    public function changeToFailedPayment(Order $order);

    /**
     * Cambia la orden a estado cancelado.
     *
     * @param Order $order
     * @return Boolean
     * @throws \Exception
     */
    public function changeToCancelled(Order $order);


    /**
     * Cambia la orden a estado entregado.
     *
     * @param Order $order
     * @return Boolean
     * @throws \Exception
     */
    public function changeToDelivered(Order $order);

    /**
     * Cambia la orden a estado pagado.
     *
     * @param Order $order
     * @return Boolean
     * @throws \Exception
     */
    public function changeToPaidOut(Order $order);

    /**
     * Actualiza los datos de que corresponden al metodo de pago en la orden
     *
     * @param Order::class $order
     * @param array $data
     * @return Order::class
     */
    public function updateDataPaymentMethod(Order $order, $data);

}

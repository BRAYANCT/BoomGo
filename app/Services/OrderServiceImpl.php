<?php


namespace App\Services;


use App\Order;
use App\Repositories\OrderRepositoryImpl;
use Illuminate\Support\Facades\Log;

class OrderServiceImpl extends GenericServiceImpl implements IOrderService
{

    public function __construct()
    {
        $this-> repository = new OrderRepositoryImpl();
    }

    /**
     * Cambia la orden a estado pago fallido.
     *
     * @param Order $order
     * @return Boolean
     * @throws \Exception
     */
    public function changeToFailedPayment(Order $order)
    {
        \DB::beginTransaction();
        try {

            $data = array(
                'id'=>$order->id,
                'order_state_id'=> config('constant.orderstate.FAILED_PAYMENT_ID'),
            );

            $this-> repository-> update($data);

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        return true;
    }

    /**
     * Cambia la orden a estado cancelado.
     *
     * @param Order $order
     * @return Boolean
     * @throws \Exception
     */
    public function changeToCancelled(Order $order)
    {
        \DB::beginTransaction();
        try {

            $data = array(
                'id'=>$order->id,
                'order_state_id'=> config('constant.orderstate.CANCELLED_ID'),
            );

            $this-> repository-> update($data);

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        return true;
    }


    /**
     * Cambia la orden a estado entregado.
     *
     * @param Order $order
     * @return Boolean
     * @throws \Exception
     */
    public function changeToDelivered(Order $order)
    {
        \DB::beginTransaction();
        try {

            $data = array(
                'id'=>$order->id,
                'order_state_id'=> config('constant.orderstate.DELIVERED_ID'),
            );

            $this-> repository-> update($data);

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        return true;
    }

    /**
     * Cambia la orden a estado pagado.
     *
     * @param Order $order
     * @return Boolean
     * @throws \Exception
     */
    public function changeToPaidOut(Order $order)
    {
        \DB::beginTransaction();
        try {

            $data = array(
                'id'=>$order->id,
                'order_state_id'=> config('constant.orderstate.PAID_OUT_ID'),
            );

            $this-> repository-> update($data);

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        return true;
    }


    /**
     * Actualiza los datos de que corresponden al metodo de pago en la orden
     *
     * @param Order::class $order
     * @param array $data
     * @return Order::class
     */
    public function updateDataPaymentMethod(Order $order, $data)
    {
        \DB::beginTransaction();
        $orderUpdate = null;
        try {

            $orderUpdate = $this->repository-> update($data);

            \DB::commit();

        } catch (\Exception $e) {

            \DB::rollBack();
            report($e);
            Log::error("Problema al guardar los datos de la plataforma de pago en la orden.");
            Log::error("M??todo de pago: {$order->paymentMethod->name}");
            Log::error("C??digo de orden: {$data['order_code_payment_method']}");

            throw new \Exception("Surgi?? un problema con el pago por favor apunte y env??enos los siguientes datos.<br>
                             M??todo de pago: {$order->paymentMethod->name}<br>
                             C??digo de orden: {$data['order_code_payment_method']}");
        }

        return $orderUpdate;
    }
}

<?php
namespace App\PaymentMethods;

use App\Order;


interface IPayment {


    /**
     * Genera el pago de un pedido
     *
     * @param Order $order
     * @param array $data
     * @return array
     */
    public function generatePayment(Order $order,array $data): array;

	/**
   	* Genera el metodo de pago y retorna el url
   	*
   	* @param Order $order
   	* @return String
  	*/
	public function setUpPaymentAndGetRedirectURL(Order $order): string;


	/**
   	* Guarda la informacion en la base de datos referente al pago
   	*
   	* @param Order $order
   	* @param array $data datos que envia la plataforma de pagos
   	* @return Boolean
  	*/
    public function updateDataPaymentMethod(Order $order,$data);

    /**
    * Cambia la orden a pago fallido
    *
    * @param Order $order
    * @param array $data datos que envia la plataforma de pagos
    * @return Boolean
    */
    public function changeToFailedPayment(Order $order,$data);

}

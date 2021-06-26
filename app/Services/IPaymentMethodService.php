<?php


namespace App\Services;


use Illuminate\Support\Collection;

interface IPaymentMethodService
{
    /**
     *  Obtiene todos los metodos de pago de los negocios de los productos del carrito de compras.
     *
     * @param string $shoppingCartToken token shopping cart
     * @return collection PaymentMethod::class
     */
    public function findAllOfShoppingCartBusinesses(string $shoppingCartToken);
}

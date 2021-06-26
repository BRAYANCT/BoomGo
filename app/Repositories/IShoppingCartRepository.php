<?php


namespace App\Repositories;


use App\ShoppingCart;
use Illuminate\Database\Eloquent\Model;

interface IShoppingCartRepository
{
    /**
     * Aumenta la cantidad de un item al carrito existente.
     * Si no existe lo crea
     *
     * @param ShoppingCart $shoppingCart
     * @param array $data datos incrementar el item
     * @return Boolean
     */
    public function increaseItem(ShoppingCart $shoppingCart, array $data);

    /**
     * Disminuye la cantidad de un item del carrito de compras.
     * Si la cantidad a disminuir el igual o supera a la cantidad actual elimina el item
     *
     * @param ShoppingCart $shoppingCart
     * @param array $data
     * @return Boolean
     */
    public function decreaseItem(ShoppingCart $shoppingCart,array $data);


    /**
     * Obtiene el carrito de compras del usuario o visitante
     *
     * @param string $cookieToken
     * @return ShoppingCart
     */
    public function getShoppingCart(string $cookieToken);


    /**
     * Mueve los producto del carrito de compra del cookie al del usuario que se ha logueado
     *
     * @param string $cookieToken
     * @return boolean
     */
    public function moveShoppingCartCookieToAuthUser(string $cookieToken);


}

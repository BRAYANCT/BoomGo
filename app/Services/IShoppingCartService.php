<?php


namespace App\Services;


use App\ShoppingCart;

interface IShoppingCartService
{
    /**
     * Aumenta la cantidad de un item al carrito existente.
     * Si no existe lo crea
     *
     * @param array $data
     * @return ShoppingCart
     */
    public function increaseItem(array $data);

    /**
     * Disminuye la cantidad de un item del carrito de compras.
     * Si la cantidad a disminuir el igual o supera a la cantidad actual elimina el item
     *
     * @param array $data
     * @return ShoppingCart
     */
    public function decreaseItem(array $data);

    /**
     * Obtiene el carrito de compras del usuario o visitante
     *
     * @param string $cookieToken
     * @return ShoppingCart
     */
    public function getShoppingCart(string $cookieToken);

    /**
     * Crea el carrito de compras para el usuario o visitante
     *
     * @param string $cookieToken
     * @return ShoppingCart
     */
    public function createShoppingCart(string $cookieToken);

    /**
     * Mueve los producto del carrito de compra del cookie al del usuario que se ha logueado
     *
     * @param string $cookieToken
     * @return boolean
     */
    public function moveShoppingCartCookieToAuthUser(string $cookieToken);
}

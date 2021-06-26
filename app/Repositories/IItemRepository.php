<?php


namespace App\Repositories;


use App\Item;
use App\Product;

interface IItemRepository
{

    /**
     * Aumenta en 1 la cantidad del item
     *
     * @param  Item $item
     * @return Boolean
     */
    public function increaseOne(Item $item);

    /**
     * Resta en 1 la cantidad del item
     *
     * @param  Item $item
     * @return Boolean
     */
    public function decreaseOne(Item $item);

    /**
     * Borra todos los items del tipo carrito de compras que tengan el producto enviado
     *
     * @param Product $product
     * @return Boolean
     * @throws \App\Exceptions\DataBaseGenericException
     */
    public function deleteAllTypeShoppingByProduct(Product $product);
}

<?php


namespace App\Repositories;


use App\Exceptions\DataBaseGenericException;
use App\Item;
use App\Product;
use App\ShoppingCart;

class ItemRepositoryImpl extends GenericRepositoryImpl implements IItemRepository
{

    public function __construct()
    {
        $this-> model = new Item();
    }

    /**
     * Aumenta en 1 la cantidad del item
     *
     * @param  Item $item
     * @return Boolean
     */
    public function increaseOne(Item $item)
    {
        try {
            $item-> quantity++;
            $item->save();
        }catch (\Exception $e) {
            throw new DataBaseGenericException($e->getMessage());
        }
        return true;
    }

    /**
     * Resta en 1 la cantidad del item
     *
     * @param  Item $item
     * @return Boolean
     */
    public function decreaseOne(Item $item)
    {
        try {
            $item-> quantity--;
            $item->save();
        }catch (\Exception $e) {
            throw new DataBaseGenericException($e->getMessage());
        }
        return true;
    }


    /**
     * Borra todos los items del tipo carrito de compras que tengan el producto enviado
     *
     * @param Product $product
     * @return Boolean
     * @throws \App\Exceptions\DataBaseGenericException
     */
    public function deleteAllTypeShoppingByProduct(Product $product)
    {
        try {

            $this->model->where('itemable_type',ShoppingCart::class)
                ->where('product_id',$product->id)
                ->delete();

        }catch (\Exception $e) {
            throw new DataBaseGenericException($e->getMessage());
        }
        return true;
    }

}

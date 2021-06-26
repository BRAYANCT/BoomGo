<?php


namespace App\Services;


use App\Item;
use App\Product;
use App\Repositories\ItemRepositoryImpl;

class ItemServiceImpl extends GenericServiceImpl implements IItemService
{


    public function __construct()
    {
        $this-> repository = new ItemRepositoryImpl();
    }


    /**
     * Aumenta en 1 la cantidad del item
     *
     * @param  Item $item
     * @return Boolean
     */
    public function increaseOne(Item $item)
    {
        \DB::beginTransaction();
        try {

            $this-> repository -> increaseOne($item);

            \DB::commit();
        }catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
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
        \DB::beginTransaction();
        try {

            $this-> repository -> decreaseOne($item);

            \DB::commit();
        }catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
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
        \DB::beginTransaction();
        try {

            $this-> repository -> deleteAllTypeShoppingByProduct($product);

            \DB::commit();
        }catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        return true;
    }

}

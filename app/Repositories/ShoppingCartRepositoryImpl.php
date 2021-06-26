<?php


namespace App\Repositories;


use App\Exceptions\DataBaseGenericException;
use App\Product;
use App\ShoppingCart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ShoppingCartRepositoryImpl extends GenericRepositoryImpl implements IShoppingCartRepository
{

    public function __construct()
    {
        $this-> model = new ShoppingCart();
    }

    /**
     * Aumenta la cantidad de un item al carrito existente.
     * Si no existe lo crea
     *
     * @param ShoppingCart $shoppingCart
     * @param array $data datos incrementar el item
     * @return Boolean
     */
    public function increaseItem(ShoppingCart $shoppingCart,array $data){
        try {

            $item = $shoppingCart-> items()
                -> where('product_id',$data['product_id'])
                ->first();

            if($item){
                $item -> quantity += $data['quantity'];
                $item-> save();
            }else{
                $product = Product::find($data['product_id']);

                $dataCreate = array(
                    'product_id'=>$data['product_id'],
                    'name'=>$product-> name,
                    'price'=>$product-> price,
                    'quantity'=>$data['quantity'],
                );

                $shoppingCart-> items()->create($dataCreate);
            }

        }catch (\Exception $e) {
            throw new DataBaseGenericException($e->getMessage());
        }
        return true;
    }

    /**
     * Disminuye la cantidad de un item del carrito de compras.
     * Si la cantidad a disminuir el igual o supera a la cantidad actual elimina el item
     *
     * @param ShoppingCart $shoppingCart
     * @param array $data
     * @return Boolean
     */
    public function decreaseItem(ShoppingCart $shoppingCart,array $data){
        try {

            $item = $shoppingCart-> items()
                -> where('product_id',$data['product_id'])
                ->first();

            if($item){

                if($item-> quantity <= $data['quantity']){
                    $item-> delete();
                }else{
                    $item -> quantity -= $data['quantity'];
                    $item-> save();
                }

            }

        }catch (\Exception $e) {
            throw new DataBaseGenericException($e->getMessage());
        }
        return true;
    }


    /**
     * Obtiene el carrito de compras del usuario o visitante
     *
     * @param string $cookieToken
     * @return ShoppingCart
     */
    public function getShoppingCart(string $cookieToken)
    {
        $relationshipNames = array('items.product.business');

        if(Auth::check()){
            $authUser = Auth::user();
            return $this-> findBy('user_id',$authUser-> id,$relationshipNames);
        }else{
            return $this-> findBy('cookie_token',$cookieToken,$relationshipNames);
        }
    }


    /**
     * Mueve los producto del carrito de compra del cookie al del usuario que se ha logueado
     *
     * @param string $cookieToken
     * @return boolean
     */
    public function moveShoppingCartCookieToAuthUser(string $cookieToken)
    {
        $authUser = Auth::user();


        try{

            $relationshipNames = array('items.product.business');

            $shoppingCartAuthUser = $this-> findBy('user_id',$authUser-> id,$relationshipNames);

            $shoppingCartCookie = $this-> findBy('cookie_token',$cookieToken,$relationshipNames);

            if($shoppingCartCookie){

                // si el usuario autenticado tiene carrito de compras
                if($shoppingCartAuthUser){

                    // todos los productos del carrito de compras los agrego a sumo a los existente de carrito del usuario autenticado
                    $shoppingCartCookie->items->each(function ($itemCookie) use($shoppingCartAuthUser) {

                        $existItem = false;
                        //verifica si existe el producto y le suma la cantidad
                        $shoppingCartAuthUser->items->each(function ($itemAuthUser)use($itemCookie,&$existItem) {
                            if($itemAuthUser->product_id == $itemCookie->product_id){
                                $existItem = true;
                                $itemAuthUser->quantity += $itemCookie->quantity;
                                $itemAuthUser->save();
                            }
                        });

                        // si no existe crea el producto
                        if(!$existItem){
                            $shoppingCartAuthUser->items()->save($itemCookie);
                        }

                    });


                }else{

                    // creo el carrito de compra del usuario autenticado
                    $shoppingCartAuthUser = $this->create([
                        'user_id' => $authUser->id
                    ]);

                    // agrego todos los productos del carrito de compra de la cookie
                    $shoppingCartCookie->items->each(function ($itemCookie) use($shoppingCartAuthUser) {
                        $shoppingCartAuthUser->items()->save($itemCookie);
                    });

                }

                // Borra todos los items del carrito de compra de la cookie
                $shoppingCartCookie->items()->delete();
            }


        }catch (\Exception $e) {
            throw new DataBaseGenericException($e->getMessage());
        }
        return true;
    }

}

<?php


namespace App\Services;


use App\Repositories\ShoppingCartRepositoryImpl;
use App\ShoppingCart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ShoppingCartServiceImpl extends GenericServiceImpl implements IShoppingCartService
{

    public function __construct()
    {
        $this-> repository = new ShoppingCartRepositoryImpl();
    }

    /**
     * Aumenta la cantidad de un item al carrito existente.
     * Si no existe lo crea
     *
     * @param array $data
     * @return ShoppingCart
     */
    public function increaseItem(array $data)
    {
        \DB::beginTransaction();
        $shoppingCart = null;
        try {

            $shoppingCart = $this->getShoppingCart($data['cookie_token']);

            if(!$shoppingCart){
                $shoppingCart = $this-> createShoppingCart($data['cookie_token']);
            }

            //Agrega el item
            $this-> repository-> increaseItem($shoppingCart, $data);

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        return $shoppingCart;
    }


    /**
     * Disminuye la cantidad de un item del carrito de compras.
     * Si la cantidad a disminuir el igual o supera a la cantidad actual elimina el item
     *
     * @param array $data
     * @return ShoppingCart
     */
    public function decreaseItem(array $data)
    {
        \DB::beginTransaction();
        $shoppingCart = null;
        try {

            $shoppingCart = $this->getShoppingCart($data['cookie_token']);

            // Solo disminuye si existe el carrito de compras
            if($shoppingCart){
                //Agrega el item
                $this-> repository-> decreaseItem($shoppingCart, $data);
            }

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        return $shoppingCart;
    }


    /**
     * Obtiene el carrito de compras del usuario o visitante
     *
     * @param string $cookieToken
     * @return ShoppingCart
     */
    public function getShoppingCart(string $cookieToken)
    {
        return $this-> repository->getShoppingCart($cookieToken);
    }

    /**
     * Crea el carrito de compras para el usuario o visitante
     *
     * @param string $cookieToken
     * @return ShoppingCart
     */
    public function createShoppingCart(string $cookieToken)
    {
        \DB::beginTransaction();
        $shoppingCart = null;
        try {

            if(Auth::check()){
                $authUser = Auth::user();
                $dataCreate = array('user_id'=>$authUser-> id);
                $shoppingCart = $this-> repository-> create($dataCreate);
            }else{
                $dataCreate = array('cookie_token'=>$cookieToken);
                $shoppingCart = $this-> repository-> create($dataCreate);
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        return $shoppingCart;
    }


    /**
     * Mueve los producto del carrito de compra del cookie al del usuario que se ha logueado
     *
     * @param string $cookieToken
     * @return boolean
     */
    public function moveShoppingCartCookieToAuthUser(string $cookieToken)
    {
        \DB::beginTransaction();
        try {

            $this-> repository-> moveShoppingCartCookieToAuthUser($cookieToken);

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();

            Log::error('No se pudo sincronizar el carrito de compras');
            Log::error('cookie shopping cart:'.$cookieToken);

            throw $e;
        }
        return true;
    }

}

<?php

namespace App\Http\Middleware\Item;

use App\ShoppingCart;
use Auth;
use Closure;
use Illuminate\Support\Facades\Log;


class UserPermissionCrudItem
{
    /**
     * Verifica si el usuario autenticado o el invitado pueden hacer el crud para el item.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        //obtiene el item
        $item = $request->route('item');

        // si el item no pertenece a carrito de compra no puede realizar accion
        if($item-> itemable_type != ShoppingCart::class){
            abort(403, trans('crud.authorization_failed'));
        }

        $shoppingCart = $item-> itemable;

        if(Auth::check()){

            $authUser = Auth::user();

            // si el carrito de compras no le pertenece al usuario autenticado no puede modificarlo
            if($shoppingCart-> user_id != $authUser-> id ){
                abort(403, trans('crud.authorization_failed'));
            }

        }else{

            // si no tiene el token del carrito de compra
            if(!$request->filled('cookie_token')){
                abort(401, trans('crud.authorization_failed'));
            }

            $cookieToken = $request->input('cookie_token');

            // si el token del carrito del item es diferente al del usuario no puede hacer el crud
            if($shoppingCart->cookie_token != $cookieToken){
                abort(401, trans('crud.authorization_failed'));
            }

        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware\Product;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthUserPermissionCrudProduct
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //obteniene el usuario authenticado
        $authUser = Auth::user();

        $product = $request->route('product');

        if(!$authUser->havePermissionCrudProduct($product)){
            abort(403, trans('crud.authorization_failed'));
        }

        return $next($request);
    }
}

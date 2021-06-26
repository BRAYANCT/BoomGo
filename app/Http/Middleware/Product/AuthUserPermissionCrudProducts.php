<?php

namespace App\Http\Middleware\Product;

use App\Product;
use Closure;
use Illuminate\Support\Facades\Auth;

class AuthUserPermissionCrudProducts
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

        $hasPermission = true;
        $products = Product::whereIn('id',$request-> arrayIds)->get();

        $products->each(function ($product, $key) use(&$hasPermission,$authUser) {
            $hasPermission = $authUser->havePermissionCrudProduct($product);
            return $hasPermission;
        });

        // No tiene permisos
        if(!$hasPermission){
            abort(403, trans('crud.authorization_failed'));
        }

        return $next($request);
    }
}

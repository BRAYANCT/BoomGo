<?php

namespace App\Http\Middleware\Shipping;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthUserPermissionCrudShipping
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

        $shipping = $request->route('shipping');

        if(!$authUser->havePermissionCrudShipping($shipping)){
            abort(403, trans('crud.authorization_failed'));
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware\Shipping;

use App\Shipping;
use Closure;
use Illuminate\Support\Facades\Auth;

class AuthUserPermissionCrudShippings
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
        $shippings = Shipping::whereIn('id',$request-> arrayIds)->get();

        $shippings->each(function ($shipping, $key) use(&$hasPermission,$authUser) {
            $hasPermission = $authUser->havePermissionCrudShipping($shipping);
            return $hasPermission;
        });

        // No tiene permisos
        if(!$hasPermission){
            abort(403, trans('crud.authorization_failed'));
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware\Order;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthUserPermissionCrudOrder
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
        Log::debug('AuthUserPermissionCrudOrder');

        //obtiene el usuario authenticado
        $authUser = Auth::user();
        //obtiene la orden
        $order = $request->route('order');

        Log::debug($order);

        if(!$authUser->havePermissionCrudOrder($order) ){
            abort(403, trans('crud.authorization_failed'));
        }

        return $next($request);
    }
}

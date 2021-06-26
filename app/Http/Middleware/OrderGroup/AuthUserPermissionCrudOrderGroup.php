<?php

namespace App\Http\Middleware\OrderGroup;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthUserPermissionCrudOrderGroup
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
        //obtiene el usuario authenticado
        $authUser = Auth::user();
        //obtiene la orden
        $orderGroup = $request->route('orderGroup');

        if(!$authUser->havePermissionCrudOrderGroup($orderGroup) ){
            abort(403, trans('crud.authorization_failed'));
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware\Business;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthUserPermissionCrudBusiness
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

        $business = $request->route('business');

        if(!$authUser->havePermissionCrudBusiness($business) ){
            abort(403, trans('crud.authorization_failed'));
        }

        return $next($request);
    }
}

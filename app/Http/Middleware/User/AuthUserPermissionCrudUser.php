<?php

namespace App\Http\Middleware\User;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthUserPermissionCrudUser
{
    /**
     * Verifica si el usuario authenticado tiene autorizacion de editar, borrar un registro
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        //obteniene el usuario authenticado
        $authUser = Auth::user();

        $user = $request->route('user');

        if(!$authUser->havePermissionCrudUser($user) ){
            abort(403, trans('crud.authorization_failed'));
        }
        return $next($request);
    }
}

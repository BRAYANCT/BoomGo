<?php

namespace App\Http\Middleware\User;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthUserPermissionCrudUsers
{
    /**
     * Verifica si el usuario authenticado tiene autorizacion de ver, editar, borrar varios registro registro .
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
        $users = User::whereIn('id',$request-> arrayIds)->get();

        $users->each(function ($user, $key) use(&$hasPermission,$authUser) {
            $hasPermission = $authUser->havePermissionCrudUser($user);
            return $hasPermission;
        });

        // No tiene permisos
        if(!$hasPermission){
            abort(403, trans('crud.authorization_failed'));
        }

        return $next($request);
    }
}

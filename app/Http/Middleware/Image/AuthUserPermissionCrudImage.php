<?php

namespace App\Http\Middleware\Image;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthUserPermissionCrudImage
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

        $image = $request->route('image');

        if(!$authUser->havePermissionCrudImage($image) ){
            abort(403, trans('crud.authorization_failed'));
        }

        return $next($request);
    }
}

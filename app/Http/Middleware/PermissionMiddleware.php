<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next , $permission)
    {   
        
        if (Auth::guest()) {
            return redirect('/login');
        }
    
        if (! $request->user()->can($permission)) {

            if (($request->ajax() && ! $request->pjax()) || $request->wantsJson()) {
                $data  = array();
                $mensaje = array();
                array_push ( $mensaje , Lang::get('crud.authorization_failed'));
                $data['valida'] = false;
                $data['mensaje'] = $mensaje;
                return response()->json($data,403);
            }

           abort(403);
        }
        return $next($request);
    }
}

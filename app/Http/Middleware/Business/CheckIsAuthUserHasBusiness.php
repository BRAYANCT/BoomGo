<?php

namespace App\Http\Middleware\Business;

use App\Helpers\ModalMessageHelper;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIsAuthUserHasBusiness
{
    /**
     * Verifica si el usuario autenticado tiene un negocio sino lo redirecciona a la pagina de crear negocio.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //obteniene el usuario authenticado
        $authUser = Auth::user();


        if(!$authUser->business ){

            $message = 'Primero debe crear su negocio para continuar.';

            if (($request->ajax() && ! $request->pjax()) || $request->wantsJson()) {
                $data  = array();
                $data['hasError'] = true;
                $data['message'] = [$message];
                return response()->json($data);
            }

            $modalMessage = ModalMessageHelper::warning([$message]);
            return redirect(route('businesses_admin.businesses.profile.create_edit'))
                ->with(['modalMessage'=>$modalMessage]);

        }

        return $next($request);
    }
}

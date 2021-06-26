<?php

namespace App\Http\Middleware\Order;

use Closure;

class CanChangeToFailedPayment
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

        $order = $request->route('order');

        //verifica si a la orden se le puede cambiar a cancelado
        if(!$order->canChangeToFailedPayment()){
            abort(403, trans('crud.authorization_failed'));
        }

        return $next($request);
    }
}

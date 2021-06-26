<?php


namespace App\Helpers;


class MercadoPagoHelper
{


    /**
     * Obtiene el url para obtener el codigo de autorizacion para vendedores de mercado pago
     *
     * @return string
     */
    public static function getUrlAuthMarketPlace()
    {
        $clientId = config('constant.paymentmethod.mercadopago.client_id');
        $redirect = config('constant.paymentmethod.mercadopago.market_place_redirect_url');
        return "https://auth.mercadopago.com.pe/authorization?client_id={$clientId}&response_type=code&platform_id=mp&redirect_uri={$redirect}";
    }

}

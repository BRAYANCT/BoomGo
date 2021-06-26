<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ModalMessageHelper;
use App\PaymentMethods\MercadoPago;
use App\Services\BusinessPaymentMethodServiceImpl;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MercadoPagoAdminController extends Controller
{
    private $businessPaymentMethodService;
    private $mercadoPago;

    public function __construct()
    {
        $this->businessPaymentMethodService = new BusinessPaymentMethodServiceImpl();
        $this->mercadoPago = new MercadoPago();
    }

        /**
     * Captura .
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectMarketPlaceAuthorization(Request $request)
    {

//        Log::debug($request->all());

        $routeRedirect = "";

        try {
            $authUser = Auth::user();

            if($authUser->canChooseBusiness()){
                $businessId = $request->filled('state') ? $request->input('state') : $authUser->business->id;
                $routeRedirect = $request->filled('state') ? "admin.business_payment_method.index" : "businesses_admin.business_payment_method.index";

            }else{
                $businessId = $authUser->business->id;

                $routeRedirect = "businesses_admin.business_payment_method.index";
            }

            if($request->filled('error')){
                $modalMessage = ModalMessageHelper::danger(['No se pudo autorizar la cuenta de mercado pago.']);

                return redirect()
                    ->route($routeRedirect)
                    ->with(['modalMessage'=>$modalMessage]);
            }

            if($request->filled('code')){

                $authCode = $request->input('code');

                $parameters = array(
                    ['business_id','=',$businessId],
                    ['payment_method_id','=',config('constant.paymentmethod.mercadopago.id')],
                );

                $businessPaymentMethod = $this->businessPaymentMethodService->findWhere($parameters);

                $credentials = $this->mercadoPago->createCredentialsVendor($authCode);

                if($businessPaymentMethod){
                    $data = array(
                        'id' => $businessPaymentMethod->id,
                        'access_token' => $credentials->access_token,
                        'public_key' => $credentials->public_key,
                        'refresh_token' => $credentials->refresh_token,
                        'client_id' => $credentials->user_id,
                        'date_expire_token' => Carbon::now()->addMonths(5),
                    );
                    $this->businessPaymentMethodService->update($data);
                }else{
                    $data = array(
                        'payment_method_id' => config('constant.paymentmethod.mercadopago.id'),
                        'business_id' => $businessId,
                        'access_token' => $credentials->access_token,
                        'public_key' => $credentials->public_key,
                        'refresh_token' => $credentials->refresh_token,
                        'client_id' => $credentials->user_id,
                        'date_expire_token' => Carbon::now()->addMonths(5),
                    );
                    $this->businessPaymentMethodService->create($data);
                }

                $modalMessage = ModalMessageHelper::success(['Se autorizó su cuenta de forma exitosa.']);

            }else{
                $modalMessage = ModalMessageHelper::danger(['No se pudo autorizar la cuenta de mercado pago.']);
            }

        }catch (\Exception $e){
            report($e);
            $modalMessage = ModalMessageHelper::danger(['Problema al autorizar la cuenta de mercado pago.']);
        }
//        Log::debug($credentials);

//        Log::debug('authCode:'.$authCode);

        return redirect()
            ->route($routeRedirect)
            ->with(['modalMessage'=>$modalMessage]);
    }
}

<?php

namespace App\Http\Controllers\Web\Api;

use App\Business;
use App\Http\Requests\Web\OrderFormWebRequest;
use App\Notifications\OrderGroup\NewOrderGroupNotification;
use App\Order;
use App\OrderGroup;
use App\PaymentMethods\PaymentFactory;
use App\Services\OrderGroupServiceImpl;
use App\Services\ShoppingCartServiceImpl;
use App\Services\UserServiceImpl;
use App\ShoppingCart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderGroupApiWebController extends Controller
{

    private $service;
    private $shoppingCartservice;

    public function __construct()
    {
        $this-> service = new OrderGroupServiceImpl();
        $this-> shoppingCartservice = new ShoppingCartServiceImpl();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(OrderFormWebRequest $request)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try {

//            Log::debug($request->all());

            $shoppingCartCookie = $request->cookie(config('constant.shoppingcart.name_cookie'));

            $shoppingCart = $this->shoppingCartservice->getShoppingCart($shoppingCartCookie);

            $orderGroup = $this-> service-> createComplete($request->validated(),new UserServiceImpl(),$shoppingCart);
            $data['model'] = $orderGroup;

            array_push ( $message , trans('crud.store_success'));
            $hasError = false;

            if(!Auth::check()){
                Auth::loginUsingId($orderGroup->user_id);
            }

            // envia el correo electronico
            if($orderGroup){
                try {

                    $when = now()->addSeconds(30);
                    $orderGroup->notify((new NewOrderGroupNotification())->delay($when));

                }catch (\Exception $e){
                    report($e);
                    Log::error('No se pudo enviar el correo para la order Group:'.$orderGroup->id);
                }
            }



//            $paymentFactory = new PaymentFactory(config('constant.paymentmethod.mercadopago.id'));
//
//            $paymentFactory->paymentMethod->generatePaymentSplit(new Order(),$request->all());

//            $urlRedirect = $paymentFactory-> paymentMethod-> setUpPaymentAndGetRedirectURL($order);

//            $data['urlRedirect'] = $urlRedirect;

        }catch(\Exception $e){
            report($e);
            // array_push ( $message , $e->getMessage());
            array_push ( $message , trans('crud.store_error'));
            $codeResponse = $e->getCode() ? $e->getCode() : 500;
        }

        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OrderFormWebRequest $request
     * @param Business $business
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeByBusiness(OrderFormWebRequest $request,Business $business)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try {

//            Log::debug($request->all());

            $shoppingCartCookie = $request->cookie(config('constant.shoppingcart.name_cookie'));

            $shoppingCart = $this->shoppingCartservice->getShoppingCart($shoppingCartCookie);

            $orderGroup = $this-> service-> createCompleteByBusiness($business,$request->validated(),new UserServiceImpl(),$shoppingCart);
            $data['model'] = $orderGroup;

            array_push ( $message , trans('crud.order.store_success'));
            $hasError = false;

            if(!Auth::check()){
                Auth::loginUsingId($orderGroup->user_id);
            }

            if($orderGroup->paymentMethod->isMercadoPago()){
                $paymentFactory = new PaymentFactory(config('constant.paymentmethod.mercadopago.id'));
                $order = $orderGroup->orders->first();
                $data['url_redirect'] = $paymentFactory->paymentMethod->setUpPaymentAndGetRedirectURL($order);

//                $paymentFactory->paymentMethod->generatePaymentSplit(new Order(),$request->all());
//                $paymentFactory->paymentMethod->generatePayment(new Order(),$request->all());

            }

            // envia el correo electronico
            if($orderGroup){
                try {

                    $when = now()->addSeconds(30);
                    $orderGroup->notify((new NewOrderGroupNotification())->delay($when));

                }catch (\Exception $e){
                    report($e);
                    Log::error('No se pudo enviar el correo para la order Group:'.$orderGroup->id);
                }
            }



        }catch(\Exception $e){
            report($e);
            // array_push ( $message , $e->getMessage());
            array_push ( $message , trans('crud.order.store_error'));
            $codeResponse = $e->getCode() ? $e->getCode() : 500;
        }

        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OrderGroup  $orderGroup
     * @return \Illuminate\Http\Response
     */
    public function show(OrderGroup $orderGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrderGroup  $orderGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderGroup $orderGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrderGroup  $orderGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderGroup $orderGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrderGroup  $orderGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderGroup $orderGroup)
    {
        //
    }
}

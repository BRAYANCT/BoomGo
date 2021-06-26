<?php

namespace App\Http\Controllers\Web\Api;

use App\Http\Requests\Web\OrderFormWebRequest;
use App\Order;
use App\PaymentMethods\PaymentFactory;
use App\Services\OrderServiceImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class OrderApiWebController extends Controller
{

    private $service;

    public function __construct()
    {
        $this-> service = new OrderServiceImpl();
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

            Log::debug($request->all());

            $order = $this-> service-> create($request->validated());

//            $data['model'] = $order;
            array_push ( $message , trans('crud.store_success'));
            $hasError = false;


            $paymentFactory = new PaymentFactory(config('constant.paymentmethod.mercadopago.id'));

            $paymentFactory->paymentMethod->generatePaymentSplit(new Order(),$request->all());

//            $urlRedirect = $paymentFactory-> paymentMethod-> setUpPaymentAndGetRedirectURL($order);

//            $data['urlRedirect'] = $urlRedirect;

        } catch(\Exception $e){
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
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}

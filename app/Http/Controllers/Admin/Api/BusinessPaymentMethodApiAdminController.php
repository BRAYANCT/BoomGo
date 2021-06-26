<?php

namespace App\Http\Controllers\Admin\Api;

use App\Business;
use App\BusinessPaymentMethod;
use App\Http\Requests\Admin\BusinessPaymentMethodWireTransferFormAdminRequest;
use App\Http\Resources\Admin\BusinessPaymentMethodAdminResource;
use App\Services\BusinessPaymentMethodServiceImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BusinessPaymentMethodApiAdminController extends Controller
{

    private $service;

    public function __construct()
    {
        $this-> service = new BusinessPaymentMethodServiceImpl();
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BusinessPaymentMethod  $businessPaymentMethod
     * @return \Illuminate\Http\Response
     */
    public function show(BusinessPaymentMethod $businessPaymentMethod)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BusinessPaymentMethod  $businessPaymentMethod
     * @return \Illuminate\Http\Response
     */
    public function edit(BusinessPaymentMethod $businessPaymentMethod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BusinessPaymentMethod  $businessPaymentMethod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BusinessPaymentMethod $businessPaymentMethod)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BusinessPaymentMethod  $businessPaymentMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusinessPaymentMethod $businessPaymentMethod)
    {
        //
    }


    /**
     * Display the specified resource.
     *
     * @param  Business  $business
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMercadoPagoByBusiness(Business $business)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try {

            $parameters = array(
                ['business_id','=',$business->id],
                ['payment_method_id','=',config('constant.paymentmethod.mercadopago.id')],
            );

            $businessPaymentMethod = $this->service->findWhere($parameters);

            $data['model'] = $businessPaymentMethod ? new BusinessPaymentMethodAdminResource($businessPaymentMethod) : null;
            array_push ( $message , trans('crud.show_success'));
            $hasError = false;

        } catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());
            array_push ( $message , trans('crud.show_error'));
            $codeResponse = $e->getCode();
        }

        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
    }


    /**
     * Display the specified resource.
     *
     * @param  Business  $business
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWireTransferByBusiness(Business $business)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try {

            $parameters = array(
                ['business_id','=',$business->id],
                ['payment_method_id','=',config('constant.paymentmethod.wire_transfer.id')],
            );

            $relationshipNames = array('accountNumbers');

            $businessPaymentMethod = $this->service->findWhere($parameters,$relationshipNames);

            $data['model'] = $businessPaymentMethod ? new BusinessPaymentMethodAdminResource($businessPaymentMethod) : null;
            array_push ( $message , trans('crud.show_success'));
            $hasError = false;

        } catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());
            array_push ( $message , trans('crud.show_error'));
            $codeResponse = $e->getCode();
        }

        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
    }

    /**
     * Guarda o actualiza una transferencia bancaria de un negocio.
     *
     * @param BusinessPaymentMethodWireTransferFormAdminRequest $request
     * @param Business $business
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeOrUpdateWireTransferByBusiness(BusinessPaymentMethodWireTransferFormAdminRequest $request,Business $business)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try {
            $model = $this-> service-> storeOrUpdateWireTransferByBusiness($business,$request->validated());

            $model = $this->service->load($model,array('accountNumbers'));

            $data['model'] = new BusinessPaymentMethodAdminResource($model);
            array_push ( $message , trans('crud.update_success'));
            $hasError = false;

        } catch(\Exception $e){
            report($e);
            array_push($message, $e->getMessage());
            array_push ( $message , trans('crud.update_error'));
            $codeResponse = $e->getCode() ? $e->getCode() : 500;
        }

        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
    }

}

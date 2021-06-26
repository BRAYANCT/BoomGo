<?php

namespace App\Http\Controllers\Web\Api;

use App\Business;
use App\District;
use App\Http\Resources\Web\ShippingWebResource;
use App\Services\ShippingServiceImpl;
use App\Shipping;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShippingApiWebController extends Controller
{

    private $service;

    public function __construct()
    {
        $this-> service = new ShippingServiceImpl();
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
     * @param  \App\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function show(Shipping $shipping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function edit(Shipping $shipping)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shipping $shipping)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shipping $shipping)
    {
        //
    }

    /**
     * Obtiene todas los envíos de los negocios de los productos del carrito de compras.
     *
     * @param Request $request
     * @param District $district
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllForShoppingCart(Request $request,District $district)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        $list = null;

        try{

            $cookieToken = $request->cookie(config('constant.shoppingcart.name_cookie'));

            $shippings = $this->service->findAllForShoppingCart($cookieToken,$district);

            $list = ShippingWebResource::collection($shippings);

            array_push ( $message , trans('crud.list_success'));
            $hasError = false;

        } catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());
            array_push ( $message , trans('crud.list_error'));
            $codeResponse = $e->getCode();
        }

        $data['list'] = $list;
        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
    }

    /**
     * Obtiene el envío de un negocio priorizando el distrito
     *
     * @param Business $business
     * @param District $district
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByBusinessAndPriorityDistrict(Business $business,District $district)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try {

            $shipping = $this->service->findByBusinessAndPriorityDistrict($business,$district);

            $data['model'] = $shipping ? new ShippingWebResource($shipping) : null;
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

}

<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Resources\Admin\OrderAdminResource;
use App\Http\Resources\Admin\OrderTableAdminResource;
use App\Order;
use App\Services\OrderServiceImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderApiAdminController extends Controller
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
     * Obtiene toda la lista de negocios.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getListToTable(Request $request)
    {

        $relationshipNames = array('business_trashed','user_trashed','orderGroup','orderState','items','paymentMethod');

        $parameters = array();

        $orders = $this-> service-> findAllWhere($parameters,$relationshipNames);

        return OrderTableAdminResource::collection($orders);
    }


    /**
     * Obtiene la lista de pedidos que tiene el negocio de un usuario autenticado.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getAllForBusinessAuthUserListToTable(Request $request)
    {
        $relationshipNames = array('business_trashed','user_trashed','orderGroup','orderState','items','paymentMethod');

        $authUser = Auth::user();

        $parameters = array(
            ['business_id','=',$authUser->business->id]
        );

        $orders = $this-> service-> findAllWhere($parameters,$relationshipNames);

        return OrderTableAdminResource::collection($orders);
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


    /**
     * Obtiene la lista de pedidos de usuario autenticado.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllForAuthUser(Request $request)
    {

        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        $list = null;

        try{

            $relationshipNames = array('orderState','items');

            $authUser = Auth::user();

            $parameters = array(
                ['user_id','=',$authUser->id],
                ['orderBy','created_at','desc'],
            );

            if($request->filled('order_state_id')){
                array_push($parameters,['order_state_id','=',$request->input('order_state_id')]);
            }

            $list = OrderAdminResource::collection($this-> service-> findAllWhere($parameters,$relationshipNames));

            array_push ( $message , trans('crud.list_success'));
            $hasError = false;

        } catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());
            array_push ( $message , trans('crud.list_error'));
            $codeResponse = $e->getCode() ? $e->getCode() : 500;
        }

        $data['list'] = $list;
        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);

    }


    /**
     * Cambia la orden a estado cancelado.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeToCancelled(Order $order)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try {
            $this-> service-> changeToCancelled($order);

            array_push ( $message , trans('crud.order.change_to_cancelled_success'));
            $hasError = false;

        } catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());
            array_push ( $message , trans('crud.order.change_to_cancelled_success'));
            $codeResponse = $e->getCode();
        }

        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
    }

    /**
     * Cambia la orden a estado entregado.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeToDelivered(Order $order)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try {
            $this-> service-> changeToDelivered($order);

            array_push ( $message , trans('crud.order.change_to_delivered_success'));
            $hasError = false;

        } catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());
            array_push ( $message , trans('crud.order.change_to_delivered_success'));
            $codeResponse = $e->getCode();
        }

        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
    }


    /**
     * Cambia la orden a estado pagado.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeToPaidOut(Order $order)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try {
            $this-> service-> changeToPaidOut($order);

            array_push ( $message , trans('crud.order.change_to_paid_out_success'));
            $hasError = false;

        } catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());
            array_push ( $message , trans('crud.order.change_to_paid_out_success'));
            $codeResponse = $e->getCode();
        }

        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
    }

}

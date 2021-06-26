<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Requests\Admin\ShippingFormAdminRequest;
use App\Http\Resources\Admin\ShippingAdminResource;
use App\Http\Resources\Admin\ShippingTableAdminResource;
use App\Services\ShippingServiceImpl;
use App\Shipping;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShippingApiAdminController extends Controller
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
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getListToTable(Request $request)
    {

        $relationshipNames = array('business','shippingable');

//        Log::debug($request->all());

        $isAdminBusiness = false;

        if($request->filled('is_admin_business'))
        {
            $isAdminBusiness = filter_var($request->input('is_admin_business'), FILTER_VALIDATE_BOOLEAN);
        }

        $parameters = array(
            ['has','business']
        );

        if($isAdminBusiness)
        {
            $authUser =  \Auth::user();
            array_push($parameters,['business_id','=',$authUser->business->id]);
        }

        $shippings = $this-> service-> findAllAllowedForAuthUser($parameters,$relationshipNames);

        return ShippingTableAdminResource::collection($shippings);
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
    public function store(ShippingFormAdminRequest $request)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try {
            $model = $this-> service-> create($request->validated());

            $data['model'] = new ShippingAdminResource($model);
            $data['modelTable'] = new ShippingTableAdminResource($model);

            array_push ( $message , trans('crud.store_success'));
            $hasError = false;

        } catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());
            array_push ( $message , trans('crud.store_error'));
            $codeResponse = $e->getCode();
        }

        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Shipping  $shipping
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Shipping $shipping)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try {

            $relationshipNames = array('business','shippingable');

            $product = $this->service->load($shipping,$relationshipNames);

            $data['model'] = new ShippingAdminResource($shipping);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ShippingFormAdminRequest $request, Shipping $shipping)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;
        //agrega el id
        $validated = $request->validated();
        $validated['id'] = $shipping-> id;

        try {
            $model = $this-> service-> update($validated);

            $data['model'] = new ShippingAdminResource($model);
            $data['modelTable'] = new ShippingTableAdminResource($model);

            array_push ( $message , trans('crud.update_success'));
            $hasError = false;

        } catch(\Exception $e){
            report($e);
            array_push($message, $e->getMessage());
            array_push ( $message , trans('crud.update_error'));
            $codeResponse = $e->getCode();
        }

        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Shipping  $shipping
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Shipping $shipping)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try{
            $result = $this-> service-> delete($shipping);

            array_push ( $message , trans('crud.delete_success'));
            $hasError = false;

        } catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());
            array_push ( $message , trans('crud.delete_error'));
            $codeResponse = $e->getCode();
        }


        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
    }


    /**
     * Remueve varios registros por el id
     *
     * @param
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyByIds(Request $request)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try {
            $this-> service-> destroy($request-> arrayIds);

            array_push ( $message , trans('crud.destroy_success'));
            $hasError = false;

        } catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());
            array_push ( $message , trans('crud.destroy_error'));
            $codeResponse = $e->getCode();
        }

        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
    }
}

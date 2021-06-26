<?php

namespace App\Http\Controllers\Admin\Api;

use App\Business;
use App\Http\Requests\Admin\BusinessFormAdminRequest;
use App\Http\Requests\Admin\BusinessProfileFormAdminRequest;
use App\Http\Resources\Admin\BusinessAdminResource;
use App\Http\Resources\Admin\BusinessTableAdminResource;
use App\Http\Resources\Admin\ProductAdminResource;
use App\Services\BusinessServiceImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BusinessApiAdminController extends Controller
{

    private $service;

    public function __construct()
    {
        $this-> service = new BusinessServiceImpl();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        $list = null;

        try{
            $list = BusinessAdminResource::collection($this-> service-> findAll());

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getListToTable()
    {
        $relationshipNames = array('user');
        return BusinessTableAdminResource::collection($this-> service-> findAll($relationshipNames));
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
    public function store(BusinessFormAdminRequest $request)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try {
            $model = $this-> service-> create($request->validated());

            $data['model'] = new BusinessAdminResource($model);
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
     * @param  \App\Business  $business
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Business $business)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try {

            $relationshipNames = array('images','providerTypes','user','district.province.department');

            $business = $this->service->load($business,$relationshipNames);

            $data['model'] = new BusinessAdminResource($business);
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
     * @param  \App\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function edit(Business $business)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Business  $business
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BusinessFormAdminRequest $request, Business $business)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;
        //agrega el id
        $validated = $request->validated();
        $validated['id'] = $business-> id;

        try {
            $model = $this-> service-> update($validated);

            $data['model'] = new BusinessAdminResource($model);
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
     * @param  \App\Business  $business
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Business $business)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try{
            $this-> service-> delete($business);

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


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeOrUpdateForAuthUser(BusinessProfileFormAdminRequest $request)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try {

            $authUser = Auth::user();
            $validated = $request->validated();
            $model = null;

            if($authUser->business){
                $validated['id'] = $authUser->business->id;
                $model = $this-> service-> update($validated);
            }else{
                $validated['user_id'] = $authUser->id;
                $model = $this-> service-> create($validated);
            }

            $data['model'] = $model ? new BusinessAdminResource($model) : null;
            array_push ( $message , $authUser->business ? trans('crud.update_success') : trans('crud.store_success'));
            $hasError = false;

        } catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());
            array_push ( $message , $authUser->business ? trans('crud.update_error') : trans('crud.store_error'));
            $codeResponse = $e->getCode();
        }

        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
    }

}

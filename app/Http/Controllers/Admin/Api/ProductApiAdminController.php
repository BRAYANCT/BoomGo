<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Requests\Admin\ProductFormAdminRequest;
use App\Http\Resources\Admin\ProductAdminResource;
use App\Http\Resources\Admin\ProductTableAdminResource;
use App\Product;
use App\Services\ProductServiceImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ProductApiAdminController extends Controller
{

    private $service;

    public function __construct()
    {
        $this-> service = new ProductServiceImpl();
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

        $relationshipNames = array('business');

//        Log::debug($request->all());

        $isAdminBusiness = false;

        if($request->filled('is_admin_business')){
            $isAdminBusiness = filter_var($request->input('is_admin_business'), FILTER_VALIDATE_BOOLEAN);
        }

        $parameters = array();

        if($isAdminBusiness){
            $authUser =  \Auth::user();
            array_push($parameters,['business_id','=',$authUser->business->id]);
        }

        $products = $this-> service-> findAllAllowedForAuthUser($parameters,$relationshipNames);

        return ProductTableAdminResource::collection($products);
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
    public function store(ProductFormAdminRequest $request)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try {
            $model = $this-> service-> create($request->validated());

            $data['model'] = new ProductAdminResource($model);
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
     * @param  \App\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try {

            $relationshipNames = array('categories','images');

            $product = $this->service->load($product,$relationshipNames);

            $data['model'] = new ProductAdminResource($product);
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
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ProductFormAdminRequest $request, Product $product)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;
        //agrega el id
        $validated = $request->validated();
        $validated['id'] = $product-> id;

        try {
            $model = $this-> service-> update($validated);

            $data['model'] = new ProductAdminResource($model);
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
     * @param  \App\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try{
            $result = $this-> service-> delete($product);

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

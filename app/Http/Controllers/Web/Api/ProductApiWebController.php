<?php

namespace App\Http\Controllers\Web\Api;

use App\Http\Resources\Web\ProductWebResource;
use App\Product;
use App\Services\ProductServiceImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ProductApiWebController extends Controller
{

    private $service;

    public function __construct()
    {
        $this-> service = new ProductServiceImpl();
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        $list = null;

        try{

            $parameters = array(
                ['has','business']
            );

            $relationshipNames = array('categories','business');

            $quantity = 5;
            if($request->filled('quantity')){
                $quantity = $request->input('quantity');
            }
            array_push($parameters,['limit',$quantity]);

            if($request->filled('business_id')){
                array_push($parameters,['business_id','=',$request->input('business_id')]);
            }

            if($request->filled('offer')){
                array_push($parameters,['offer',$request->input('offer')]);
            }

            if($request->filled('best_offer')){
                array_push($parameters,['best_offer',true]);
            }

            if($request->filled('last')){
                array_push($parameters,['orderBy','last']);
            }

            if($request->filled('category_id')){
                array_push($parameters,['category_id',$request->input('category_id')]);
            }

            if($request->filled('different_product')){
                array_push($parameters,['id','!=',$request->input('different_product')]);
            }



            $list = ProductWebResource::collection($this-> service-> findAllWhere($parameters,$relationshipNames));

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

            $relationshipNames = array('business','categories');

            $product = $this->service->load($product,$relationshipNames);

            $data['model'] = new ProductWebResource($product);
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}

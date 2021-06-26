<?php

namespace App\Http\Controllers\Web\Api;

use App\Business;
use App\Http\Resources\Web\ImageWebResource;
use App\Image;
use App\Product;
use App\Services\ImageServiceImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImageApiWebController extends Controller
{

    private $service;

    public function __construct()
    {
        $this-> service = new ImageServiceImpl();
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
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }


    /**
     * Obtiene todas las images de un producto.
     *
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllProductImages(Product $product)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        $list = null;

        try{
            $relationshipNames = array('images');
            $this->service->load($product,$relationshipNames);
            $images = $product->images;
            $list = ImageWebResource::collection($images);
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
     * Obtiene todas las images de un negocio.
     *
     * @param Business $business
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllBusinessImages(Business $business)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        $list = null;

        try{
            $relationshipNames = array('images');
            $this->service->load($business,$relationshipNames);
            $images = $business->images;
            $list = ImageWebResource::collection($images);
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

}

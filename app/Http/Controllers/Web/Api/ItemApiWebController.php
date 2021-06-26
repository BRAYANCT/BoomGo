<?php

namespace App\Http\Controllers\Web\Api;

use App\Item;
use App\Services\ItemServiceImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemApiWebController extends Controller
{

    private $service;

    public function __construct()
    {
        $this-> service = new ItemServiceImpl();
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
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Item $item)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try{
            $this-> service-> delete($item);

            array_push ( $message , trans('crud.item.delete_success'));
            $hasError = false;

        } catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());
            array_push ( $message , trans('crud.item.delete_error'));
            $codeResponse = $e->getCode();
        }


        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
    }


    /**
     * Aumenta en 1 la cantidad del item.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function increaseOne(Item $item)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try{
            $this-> service-> increaseOne($item);

            array_push ( $message , trans('crud.item.increase_item_success'));
            $hasError = false;

        } catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());
            array_push ( $message , trans('crud.item.increase_item_error'));
            $codeResponse = $e->getCode();
        }


        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
    }


    /**
     * Disminuye en 1 la cantidad del item.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function decreaseOne(Item $item)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try{
            $this-> service-> decreaseOne($item);

            array_push ( $message , trans('crud.item.decrease_item_success'));
            $hasError = false;

        } catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());
            array_push ( $message , trans('crud.item.decrease_item_error'));
            $codeResponse = $e->getCode();
        }


        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
    }

}

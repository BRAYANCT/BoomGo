<?php

namespace App\Http\Controllers\Web\Api;

use App\Http\Requests\Web\ShoppingCartModifyItemRequest;
use App\Http\Resources\Web\ShoppingCartWebResource;
use App\Services\ShoppingCartServiceImpl;
use App\ShoppingCart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ShoppingCartApiWebController extends Controller
{

    private $service;

    public function __construct()
    {
        $this-> service = new ShoppingCartServiceImpl();
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
     * @param  \App\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function show(ShoppingCart $shoppingCart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function edit(ShoppingCart $shoppingCart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShoppingCart $shoppingCart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShoppingCart $shoppingCart)
    {
        //
    }


    /**
     * Obtiene el carrito de compras del usuario autenticado.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getShoppingCartUser(Request $request)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try {

//            Log::debug("cookieShoppinhCart:".$request->cookie(config('constant.shoppingcart.name_cookie')));

            $userAuth = Auth::user();

            $relationshipNames = array('items.product');

            $model = $this-> service-> getShoppingCart($request->input('cookie_token'));

            if($model){
                $data['model'] = new ShoppingCartWebResource($model);
            }else{
                $data['model'] = $model;
            }

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
     * Aumenta la cantidad de un item al carrito existente,Si no existe lo crea.
     * Si el carrito no existe lo crea
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function increaseItem(ShoppingCartModifyItemRequest $request)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try {

            $model = $this-> service-> increaseItem($request->validated());

            $relationshipNames = array('items');
            $model = $this-> service-> load($model,$relationshipNames);

            $data['model'] = new ShoppingCartWebResource($model);
            array_push ( $message , trans('crud.shopping_cart.increase_item_success'));
            $hasError = false;

        }catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());
            array_push ( $message , trans('crud.shopping_cart.increase_item_error'));
            $codeResponse = $e->getCode();
        }

        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
    }


    /**
     * Disminuye la cantidad de un item del carrito de compras.
     * Si la cantidad a disminuir el igual o supera a la cantidad actual elimina el item
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function decreaseItem(ShoppingCartModifyItemRequest $request)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try {
            $model = $this-> service-> decreaseItem($request->validated());

            $relationshipNames = array('items');
            $model = $this-> service-> load($model,$relationshipNames);

            $data['model'] = new ShoppingCartWebResource($model);
            array_push ( $message , trans('crud.shopping_cart.decrease_item_success'));
            $hasError = false;

        }catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());
            array_push ( $message , trans('crud.shopping_cart.decrease_item_error'));
            $codeResponse = $e->getCode();
        }

        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
    }

}

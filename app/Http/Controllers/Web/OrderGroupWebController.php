<?php

namespace App\Http\Controllers\Web;

use App\OrderGroup;
use App\Services\OrderGroupServiceImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderGroupWebController extends Controller
{

    private $service;
    private $prefixRouteWeb = "order_groups.";
    private $prefixRouteApi = "api.order_groups.";

    private $prefixView = "web.order-group.";

    public function __construct()
    {
        $this-> service = new OrderGroupServiceImpl();

        view()->share('prefixRouteWeb', $this-> prefixRouteWeb);
        view()->share('prefixRouteApi', $this-> prefixRouteApi);
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
     * @param  \App\OrderGroup  $orderGroup
     * @return \Illuminate\Http\Response
     */
    public function show(OrderGroup $orderGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrderGroup  $orderGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderGroup $orderGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrderGroup  $orderGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderGroup $orderGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrderGroup  $orderGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderGroup $orderGroup)
    {
        //
    }


    /**
     * Muestra la pagina de checkout agradecimiento
     *
     * @param  OrderGroup  $orderGroup
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function showCheckoutThanks(OrderGroup $orderGroup)
    {
        $title = "Checkout thanks";
        $description = "";
        return view($this-> prefixView.'checkout-thanks',compact('title','orderGroup','description'));
    }

}

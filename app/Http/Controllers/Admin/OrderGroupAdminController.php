<?php

namespace App\Http\Controllers\Admin;

use App\OrderGroup;
use App\Services\OrderGroupServiceImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderGroupAdminController extends Controller
{

    private $service;

    private $prefixRouteWeb = "admin.order_groups.";
    private $prefixRouteApi = "api.admin.order_groups.";

    private $prefixView = "admin.order-group.";

    public function __construct()
    {
        $this->service = new OrderGroupServiceImpl();

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
     * Muestra la vista con los pedidos que hizo el usuario autenticado.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function getAllForAuthUser()
    {
        $title = "Mis compras";
        $urlApiList = route('api.admin.orders.business_auth_user.list_table.index');
        return view($this-> prefixView.'list-for-auth-user',compact('title','urlApiList'));
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
}

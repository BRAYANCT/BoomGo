<?php

namespace App\Http\Controllers\Admin;

use App\Order;
use App\Services\OrderServiceImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderAdminController extends Controller
{

    private $service;

    private $prefixRouteWeb = "admin.orders.";
    private $prefixRouteApi = "api.admin.orders.";

    private $prefixView = "admin.order.";

    public function __construct()
    {
        $this->service = new OrderServiceImpl();

        view()->share('prefixRouteWeb', $this-> prefixRouteWeb);
        view()->share('prefixRouteApi', $this-> prefixRouteApi);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $title = "Lista de pedidos";

        $urlApiList = route('api.admin.orders.list_table.index');

        return view($this-> prefixView.'list',compact('title','urlApiList'));
    }

    /**
     * Muestra la vista de los pedidos del negocio del usuario autenticado.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function getAllForBusinessAuthUser()
    {
        $title = "Mis pedidos";
        $urlApiList = route('api.admin.orders.business_auth_user.list_table.index');
        return view($this-> prefixView.'list',compact('title','urlApiList'));
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(Order $order)
    {
        $title = "Detalle del pedido";

        $relationshipNames = array('business_trashed','user_trashed','items','orderGroup','orderState','billingInformation');

        $model = $this->service->load($order,$relationshipNames);

        return view($this-> prefixView.'show',compact('title','model'));
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
     * Muestra la vista del menu de mis compras con los estados agrupados.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function getMenuForAuthUser()
    {
        $title = "Mis compras";
        return view($this-> prefixView.'list-menu-for-auth-user',compact('title'));
    }

    /**
     * Muestra la vista con los pedidos o compras que hizo el usuario autenticado.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function getAllForAuthUser()
    {
        $title = "Mis compras";
        return view($this-> prefixView.'list-for-auth-user',compact('title'));
    }

    /**
     * Muestra la pantalla con la compra del usuario autenticado.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function showForAuthUser(Order $order)
    {
        $title = "Detalle de compra";

        $relationshipNames = array('business_trashed','user_trashed','items','orderGroup','orderState','billingInformation');

        $model = $this->service->load($order,$relationshipNames);

        return view($this-> prefixView.'show-for-auth-user',compact('title','model'));
    }
}

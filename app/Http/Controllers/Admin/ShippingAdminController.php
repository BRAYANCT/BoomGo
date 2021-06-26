<?php

namespace App\Http\Controllers\Admin;

use App\Services\ShippingServiceImpl;
use App\Shipping;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShippingAdminController extends Controller
{
    private $service;
    private $prefixRouteWeb = "admin.shippings.";
    private $prefixRouteApi = "api.admin.shippings.";

    private $prefixView = "admin.shipping.";

    public function __construct()
    {
        $this-> service = new ShippingServiceImpl();

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
     * @param  \App\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function show(Shipping $shipping)
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shipping $shipping)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shipping $shipping)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function showFormList()
    {
        $title = "Envíos";

        return view($this->prefixView."form-list",compact('title'));
    }

}

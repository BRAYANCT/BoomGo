<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use App\Services\ProductServiceImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductAdminController extends Controller
{

    private $service;

    private $prefixRouteWeb = "admin.products.";
    private $prefixRouteApi = "api.admin.products.";

    private $prefixView = "admin.product.";

    public function __construct()
    {
        $this->service = new ProductServiceImpl();

        // cambia el prefix cuando esta dentro del negocio
        if(\Request::is('businesses-admin/*')){
            $this-> prefixRouteWeb = "businesses_admin.products.";
        }

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
        $title = "Lista de productos";
        return view($this-> prefixView.'list',compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $title = "Registrar producto";
        $model = new Product();
        return view($this-> prefixView.'form',compact('title','model'));
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
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Product $product)
    {
        $title = "Editar producto";
        $model = $product;
        return view($this-> prefixView.'form',compact('title','model'));

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

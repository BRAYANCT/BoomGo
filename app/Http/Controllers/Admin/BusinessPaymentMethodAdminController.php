<?php

namespace App\Http\Controllers\Admin;

use App\BusinessPaymentMethod;
use App\Services\BusinessPaymentMethodServiceImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BusinessPaymentMethodAdminController extends Controller
{

    private $service;
    private $prefixRouteWeb = "admin.business_payment_method.";
    private $prefixRouteApi = "api.admin.business_payment_method.";

    private $prefixView = "admin.business-payment-method.";

    public function __construct()
    {
        $this-> service = new BusinessPaymentMethodServiceImpl();

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
        $title = "Métodos de pago";
        return view($this->prefixView."form",compact('title'));
    }


    /**
     * Display la pagina.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function showPageByBusinessAuthUser()
    {
        $title = "Métodos de pago";
        $business = Auth::user()->business;
        return view($this->prefixView."form",compact('title','business'));
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
     * @param  \App\BusinessPaymentMethod  $businessPaymentMethod
     * @return \Illuminate\Http\Response
     */
    public function show(BusinessPaymentMethod $businessPaymentMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BusinessPaymentMethod  $businessPaymentMethod
     * @return \Illuminate\Http\Response
     */
    public function edit(BusinessPaymentMethod $businessPaymentMethod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BusinessPaymentMethod  $businessPaymentMethod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BusinessPaymentMethod $businessPaymentMethod)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BusinessPaymentMethod  $businessPaymentMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusinessPaymentMethod $businessPaymentMethod)
    {
        //
    }
}

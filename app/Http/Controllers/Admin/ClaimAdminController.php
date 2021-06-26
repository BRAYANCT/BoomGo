<?php

namespace App\Http\Controllers\Admin;

use App\Claim;
use App\Services\ClaimServiceImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClaimAdminController extends Controller
{

    private $service;

    private $prefixRouteWeb = "admin.claims.";
    private $prefixRouteApi = "api.admin.claims.";

    private $prefixView = "admin.claim.";

    public function __construct()
    {
        $this->service = new ClaimServiceImpl();

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
        $title = "Libro de reclamaciones";
        return view($this-> prefixView.'list',compact('title'));
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
     * @param  \App\Claim  $claim
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(Claim $claim)
    {
        $title = "Detalle del reclamo";

        $relationshipNames = array('district.province.department','documentType','tutorDocumentType');

        $model = $this->service->load($claim,$relationshipNames);

        return view($this-> prefixView.'show',compact('title','model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Claim  $claim
     * @return \Illuminate\Http\Response
     */
    public function edit(Claim $claim)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Claim  $claim
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Claim $claim)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Claim  $claim
     * @return \Illuminate\Http\Response
     */
    public function destroy(Claim $claim)
    {
        //
    }
}

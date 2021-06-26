<?php

namespace App\Http\Controllers\Web;

use App\Claim;
use App\Services\ClaimServiceImpl;
use App\Services\DocumentTypeServiceImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClaimWebController extends Controller
{

    private $service;
    private $documentTypeService;

    private $prefixRouteWeb = "claims.";
    private $prefixRouteApi = "api.claims.";

    private $prefixView = "web.claim.";

    public function __construct()
    {
        $this->service = new ClaimServiceImpl();
        $this->documentTypeService = new DocumentTypeServiceImpl();

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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $title = "Libro de reclamaciones";
        $description = "";

        $parameters = array(
            ['orderBy','created_at','desc']
        );

        $lastClaim = $this->service->findWhere($parameters);

        if($lastClaim){
            $lastClaim->id += 1;
            $nextCode = $lastClaim->code;
        }else{
            $nextCode = "001";
        }



        return view($this-> prefixView.'form',compact('title','description','nextCode'));
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
     * @return \Illuminate\Http\Response
     */
    public function show(Claim $claim)
    {
        //
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

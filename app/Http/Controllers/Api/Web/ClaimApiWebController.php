<?php

namespace App\Http\Controllers\Api\Web;

use App\Claim;
use App\Http\Requests\Web\ClaimStoreWebRequest;
use App\Services\ClaimServiceImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClaimApiWebController extends Controller
{

    private $service;

    public function __construct()
    {
        $this-> service = new ClaimServiceImpl();
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ClaimStoreWebRequest $request)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try {

            $claim = $this-> service-> create($request->validated());
            $data['model'] = $claim;

            array_push ( $message , trans('crud.claim.store_success'));
            $hasError = false;

        }catch(\Exception $e){
            report($e);
            // array_push ( $message , $e->getMessage());
            array_push ( $message , trans('crud.claim.store_error'));
            $codeResponse = $e->getCode() ? $e->getCode() : 500;
        }

        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
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

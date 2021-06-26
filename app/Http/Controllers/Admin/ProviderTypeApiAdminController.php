<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\Admin\ProviderTypeAdminResource;
use App\ProviderType;
use App\Services\ProviderTypeServiceImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProviderTypeApiAdminController extends Controller
{

    private $service;

    public function __construct()
    {
        $this-> service = new ProviderTypeServiceImpl();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        $list = null;

        try{

            $parameters = array(
            );

            $relationshipNames = array();

            $list = ProviderTypeAdminResource::collection($this-> service-> findAllWhere($parameters,$relationshipNames));

            array_push ( $message , trans('crud.list_success'));
            $hasError = false;

        } catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());
            array_push ( $message , trans('crud.list_error'));
            $codeResponse = $e->getCode();
        }

        $data['list'] = $list;
        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
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
     * @param  \App\ProviderType  $providerType
     * @return \Illuminate\Http\Response
     */
    public function show(ProviderType $providerType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProviderType  $providerType
     * @return \Illuminate\Http\Response
     */
    public function edit(ProviderType $providerType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProviderType  $providerType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProviderType $providerType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProviderType  $providerType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProviderType $providerType)
    {
        //
    }
}

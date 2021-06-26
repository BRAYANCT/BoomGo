<?php

namespace App\Http\Controllers\Admin\Api;

use App\BillingInformation;
use App\Http\Resources\Admin\BillingInformationAdminResource;
use App\Services\BillingInformationServiceImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BillingInformationApiAdminController extends Controller
{

    private $service;

    public function __construct()
    {
        $this-> service = new BillingInformationServiceImpl();
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
     * @param  \App\BillingInformation  $billingInformation
     * @return \Illuminate\Http\Response
     */
    public function show(BillingInformation $billingInformation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BillingInformation  $billingInformation
     * @return \Illuminate\Http\Response
     */
    public function edit(BillingInformation $billingInformation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BillingInformation  $billingInformation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BillingInformation $billingInformation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BillingInformation  $billingInformation
     * @return \Illuminate\Http\Response
     */
    public function destroy(BillingInformation $billingInformation)
    {
        //
    }


    /**
     * Obtiene los datos del usuario atenticado.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLastOneForAuthUser()
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try {

//            $authUSer = Auth::check() ?  Auth::user() : null;


//            $authUSer = $this->service->load($authUSer,$relationshipNames);
            $relationshipNames = array('district.province');
            $billingInformation = $this->service->findLastForAuthUser($relationshipNames);

            $data['model'] = $billingInformation ? new BillingInformationAdminResource($billingInformation) : null;

            array_push ( $message , trans('crud.show_success'));
            $hasError = false;

        } catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());
            array_push ( $message , trans('crud.show_error'));
            $codeResponse = $e->getCode();
        }

        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
    }
}

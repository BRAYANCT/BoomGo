<?php

namespace App\Http\Controllers\Web\Api;

use App\Business;
use App\Http\Resources\Web\BusinessWebResource;
use App\Services\BusinessServiceImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BusinessApiWebController extends Controller
{

    private $service;

    public function __construct()
    {
        $this-> service = new BusinessServiceImpl();
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
     * @param  \App\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function show(Business $business)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function edit(Business $business)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Business $business)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Business  $business
     * @return \Illuminate\Http\Response
     */
    public function destroy(Business $business)
    {
        //
    }

    /**
     * Obtiene el listado de los negocios recomendados.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllRecommended(Request $request)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        $list = null;

        try{
            $parameters = array(
                ['orderBy','recommended']
            );

            $limit = 5;
            if($request->filled('limit')){
                $limit = $request->input('limit');
            }
            array_push($parameters,['limit',$limit]);

            $relationshipNames = array('reviews');
            $list = BusinessWebResource::collection($this->service->findAllWhere($parameters,$relationshipNames));
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
}

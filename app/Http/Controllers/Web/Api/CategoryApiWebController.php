<?php

namespace App\Http\Controllers\Web\Api;

use App\Category;
use App\Http\Resources\Web\CategoryWebResource;
use App\Services\CategoryServiceImpl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class CategoryApiWebController extends Controller
{
    private $service;

    public function __construct()
    {
        $this-> service = new CategoryServiceImpl();
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
     * @param Request $request
     * @param \App\Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request,Category $category)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try {

//            Log::debug($request->all());

            $relationshipNames = array();


            if($request->filled('business_id')){
                $businessId = $request->input('business_id');

                $relationshipNames['childs'] = function ($query)use($businessId) {
                    $query->whereHas('products', function ($query1)use($businessId) {
                        $query1->where('business_id',$businessId);
                    });
                };

                $relationshipNames['parent.childs'] =  function ($query)use($businessId) {
                    $query->whereHas('products', function ($query1)use($businessId) {
                        $query1->where('business_id',$businessId);
                    });
                };

            }else{
                $relationshipNames = array('childs','parent.childs');
            }


            $this->service->load($category,$relationshipNames);

            $data['model'] = new CategoryWebResource($category);
            array_push ( $message , trans('crud.show_success'));
            $hasError = false;

        } catch(\Exception $e){
            report($e);
            array_push ( $message , trans('crud.show_error'));
            $codeResponse = $e->getCode();
        }

        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }


    /**
     * Obtiene el listado de categorias de los negocios.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBusinessCategories(Request $request)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        $list = null;

        try{
            $parameters = array(
                ['category_type_id',config('constant.categorytype.business_id')],
                ['orderBy','name','asc']
            );

//            Log::debug($request->all());

            if($request->filled('level')){
                array_push($parameters,['level','=',$request->input('level')]);
            }

            $relationshipNames = array('childs','businesses');

            $list = CategoryWebResource::collection($this->service->findAllWhere($parameters,$relationshipNames));
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
     * Obtiene el listado de categorias de los productos.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProductCategories(Request $request)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        $list = null;

        try{
            $parameters = array(
                ['category_type_id',config('constant.categorytype.product_id')],
                ['orderBy','name','asc']
            );

//            Log::debug($request->all());

            if($request->filled('level')){
                array_push($parameters,['level',$request->input('level')]);
            }

            if($request->filled('limit')){
                array_push($parameters,['limit',$request->input('limit')]);
            }

            if($request->filled('business_id')) {
                array_push($parameters, ['product_business', $request->input('business_id') ]);
            }

            $relationshipNames = array('childs');

            $list = CategoryWebResource::collection($this->service->findAllWhere($parameters,$relationshipNames));
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

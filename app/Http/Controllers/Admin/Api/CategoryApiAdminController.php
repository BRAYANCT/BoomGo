<?php

namespace App\Http\Controllers\Admin\Api;

use App\Category;
use App\CategoryType;
use App\Http\Resources\Admin\CategoryAdminResource;
use App\Http\Resources\Admin\CategoryTableAdminResource;
use App\Services\CategoryServiceImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryApiAdminController extends Controller
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
     * Display a listing of the resource.
     *
     * @param CategoryType $categoryType
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getAllByCategoryTypeToTable(CategoryType $categoryType)
    {
        $relationshipNames = array('parent');
        $parameters =array(['category_type_id','=',$categoryType-> id]);
        return CategoryTableAdminResource::collection($this-> service-> findAllWhere($parameters,$relationshipNames));
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
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try{
            $this-> service-> delete($category);

            array_push ( $message , trans('crud.delete_success'));
            $hasError = false;

        } catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());
            array_push ( $message , trans('crud.delete_error'));
            $codeResponse = $e->getCode();
        }


        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
    }


    /**
     * Remueve varios registros por el id
     *
     * @param
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyByIds(Request $request)
    {
        $data = array();
        $message = array();
        $hasError = true;
        $codeResponse = 200;

        try {
            $this-> service-> destroy($request-> arrayIds);

            array_push ( $message , trans('crud.destroy_success'));
            $hasError = false;

        } catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());
            array_push ( $message , trans('crud.destroy_error'));
            $codeResponse = $e->getCode();
        }

        $data['hasError'] = $hasError;
        $data['message'] = $message;
        return response()->json($data,$codeResponse);
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

            $relationshipNames = array('childs');

            $parameters = array(
                ['category_type_id',config('constant.categorytype.business_id')],
                ['orderBy','name','asc']
            );

            if($request->filled('level')){
                array_push($parameters,['level',$request->input('level')]);
            }

            $list = CategoryAdminResource::collection($this->service->findAllWhere($parameters,$relationshipNames));
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

            $relationshipNames = array('childs');

            $parameters = array(
                ['category_type_id',config('constant.categorytype.product_id')],
                ['orderBy','name','asc']
            );

            if($request->filled('level')){
                array_push($parameters,['level',$request->input('level')]);
            }

            $list = CategoryAdminResource::collection($this->service->findAllWhere($parameters,$relationshipNames));
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

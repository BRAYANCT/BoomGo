<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Helpers\ModalMessageHelper;
use App\Http\Requests\Admin\CategoryFormAdminRequest;
use App\Services\CategoryServiceImpl;
use App\Services\CategoryTypeServiceImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryAdminController extends Controller
{
    private $service;
    private $categoryTypeService;

    private $prefixRouteWeb = "admin.categories.";
    private $prefixRouteApi = "api.admin.categories.";

    private $prefixView = "admin.category.";

    public function __construct()
    {
        $this->service = new CategoryServiceImpl();
        $this->categoryTypeService = new CategoryTypeServiceImpl();

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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryFormAdminRequest $request)
    {
        $message = array();

        $validated = $request->validated();
        $user = null;
        try{
            $user = $this-> service-> create($validated);

        }catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());
            array_push ( $message ,trans('crud.store_error'));
            $modalMessage = ModalMessageHelper::error($message);
            return redirect()->back()
                ->withInput()
                ->with(['modalMessage'=>$modalMessage]);
        }

        $modalMessage = ModalMessageHelper::success([trans('crud.store_success')]);

        return redirect()->route($this->prefixRouteWeb.'edit',[$user])
            ->with(['modalMessage'=>$modalMessage]);
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Category $category)
    {
        $categoryType = $category->categoryType;

        $title = "Editar categoría del ".$categoryType->name;
        $model = $category;

        $parameters = array(
            ['id','!=',$category->id],
            ['category_type_id','=',$categoryType->id],
        );
        $parentCategories = $this->service->findAllCanHaveChildren($parameters);

        return view($this-> prefixView.'category-type.form',compact('title','model','categoryType','parentCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryFormAdminRequest $request, Category $category)
    {
        $message = array();

        $validated = $request->validated();
        $validated['id'] = $category-> id;

        try{
            $business = $this-> service-> update($validated);
        }catch(\Exception $e) {
            report($e);
            array_push($message, $e->getMessage());

            array_push($message, trans('crud.update_error'));

            return redirect()->back()
                ->withInput()
                ->with(['modalMessage' => ModalMessageHelper::error($message)]);
        }

        $modalMessage = ModalMessageHelper::success([trans('crud.update_success')]);

        return redirect()->route($this->prefixRouteWeb.'edit',[$business])
            ->with(['modalMessage'=>$modalMessage]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        $message = array();

        try{
            $this-> service-> delete($category);
        }catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());
            array_push ( $message , trans('crud.delete_error'));
            return redirect()->back()
                ->withInput()
                ->with(['modalMessage'=>ModalMessageHelper::error($message)]);
        }

        $modalMessage = ModalMessageHelper::success([trans('crud.delete_success')]);

        return redirect()->route($this->prefixRouteWeb.'category_type_slug.index',$category->categoryType->slug)
            ->with(['modalMessage'=>$modalMessage]);
    }


    /**
     * Muestra la pantalla con las categorias segun el tipo de categoria.
     *
     * @param string $categoryTypeSlug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function getAllByCategoryTypeSlug(string $categoryTypeSlug)
    {
        $categoryType = $this-> categoryTypeService->findBy('slug',$categoryTypeSlug);
        if(!$categoryType){
            abort(404);
        }
        $title = "Categorías del ".mb_strtolower($categoryType->name);

        return view($this->prefixView.'category-type.list',compact('title','categoryType'));
    }


    /**
     * Muestra el formulario para crear la categoria segun el tipo de categoria
     *
     * @param string $categoryTypeSlug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function createByCategoryTypeSlug(string $categoryTypeSlug)
    {
        $model = new Category();
        $categoryType = $this-> categoryTypeService->findBy('slug',$categoryTypeSlug);

        if(!$categoryType){
            abort(404);
        }

        $parameters = array(
            ['category_type_id','=',$categoryType->id],
        );
        $parentCategories = $this->service->findAllCanHaveChildren($parameters);

        $title = "Registrar categoría del ".strtolower($categoryType->name);

        return view($this-> prefixView.'category-type.form',compact('title','model','categoryType','parentCategories'));
    }




}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Resources\Web\ProductWebResource;
use App\Product;
use App\Services\BusinessServiceImpl;
use App\Services\CategoryServiceImpl;
use App\Services\ProductServiceImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ProductWebController extends Controller
{

    private $service;
    private $categoryService;
    private $businessService;

    private $prefixRouteWeb = "products.";
    private $prefixRouteApi = "api.products.";

    private $prefixView = "web.product.";

    public function __construct()
    {
        $this->service = new ProductServiceImpl();
        $this->businessService = new BusinessServiceImpl();
        $this->categoryService = new CategoryServiceImpl();

        view()->share('prefixRouteWeb', $this-> prefixRouteWeb);
        view()->share('prefixRouteApi', $this-> prefixRouteApi);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $title = "Market place";

        $title = $this->getTitleByParameters($title,$request);

        $description = "";

        $parameters = array();
        $relationshipNames = array('business');

        $parameters = $this-> addParametersToList($parameters,$request);

        $products = $this->service->findAllWithPagination($parameters,$relationshipNames);

        $productsResource = ProductWebResource::collection(collect($products->items()));

        return view($this->prefixView."list",compact('title','description','products','productsResource'));
    }

    /**
     * Muestra la pagina de los productos de un negocio.
     *
     * @param Request $request
     * @param string $slug Slug del negocio
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|\View
     */
    public function getAllByBusinessSlug(Request $request,string $slug)
    {

        $business = $this->businessService->findBy('slug',$slug);

        if(!$business){
            abort(404);
        }

        $title = "Market place - ".$business->name;

        $title = $this->getTitleByParameters($title,$request);

        $description = "";

        $parameters = array(
            ['business_id','=',$business->id]
        );

        $relationshipNames = array('business');

        $parameters = $this-> addParametersToList($parameters,$request);

        $products = $this->service->findAllWithPagination($parameters,$relationshipNames);

        $productsResource = ProductWebResource::collection(collect($products->items()));

        return view($this->prefixView."list",compact('title','description','products','productsResource','business'));
    }

    /**
     * Muestra la pagina de los productos que pertenecen a la categoria de un negocio .
     *
     * @param Request $request
     * @param string $businessSlug Slug del negocio
     * @param string $categorySlug Slug de la categoria
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|\View
     */
    public function getAllByBusinessSlugAndCategorySlug(Request $request,string $businessSlug,string $categorySlug)
    {

        $business = $this->businessService->findBy('slug',$businessSlug);

        $parametersCategory = array(
            ['category_type_id','=',config('constant.categorytype.product_id')],
            ['slug','=',$categorySlug],
        );
        $category = $this->categoryService->findWhere($parametersCategory);

        if(!$business || !$category){
            abort(404);
        }

        $title = "Market place - ".$business->name." - ".$category->name;

        $title = $this->getTitleByParameters($title,$request);

        $description = "";

        $parameters = array(
            ['business_id','=',$business->id],
            ['category_id_with_childs','=',$category->id]
        );

        $relationshipNames = array('business');

        $parameters = $this-> addParametersToList($parameters,$request);

        $products = $this->service->findAllWithPagination($parameters,$relationshipNames);

        $productsResource = ProductWebResource::collection(collect($products->items()));

        return view($this->prefixView."list",compact('title','description','products','productsResource','category','business'));
    }


    /**
     * Muestra la pagina de los productos que pertenecen a la categoria de un negocio .
     *
     * @param Request $request
     * @param string $businessSlug Slug del negocio
     * @param string $categorySlug Slug de la categoria
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|\View
     */
    public function getAllByCategorySlug(Request $request,string $slug)
    {

        $parametersCategory = array(
            ['category_type_id','=',config('constant.categorytype.product_id')],
            ['slug','=',$slug],
        );

        $category = $this->categoryService->findWhere($parametersCategory);

        if(!$category){
            abort(404);
        }

        $title = "Market place - ".$category->name;

        $title = $this->getTitleByParameters($title,$request);

        $description = "";

        $parameters = array(
            ['category_id_with_childs','=',$category->id]
        );

        $relationshipNames = array('business');

        $parameters = $this-> addParametersToList($parameters,$request);

        $products = $this->service->findAllWithPagination($parameters,$relationshipNames);

        $productsResource = ProductWebResource::collection(collect($products->items()));

        return view($this->prefixView."list",compact('title','description','products','productsResource','category'));
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
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }


    /**
     * Muestra la pagina del producto por su slug.
     *
     * @param string $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|\View
     */
    public function showBySlug(string $slug)
    {

        $product = $this->service->findBy('slug',$slug);

        if(!$product){
            abort(404);
        }

        $title = $product->name;
        $description = "";

//        dd('hola1');

        return view($this->prefixView."detail",compact('title','description','product'));
    }


    /**
     * Agrega al titulo los parametros.
     *
     * @param string $title
     * @param Request $request
     * @return string
     */
    public function getTitleByParameters(string $title, Request $request)
    {
        if($request->filled('offer')) {
            $title .= " - Ofertas";
        }
        return $title;
    }

    /**
     * Pone los parametros que se necesitan para la lista de negocio.
     *
     * @param array $parameters
     * @param Request $request
     * @return array
     */
    public function addParametersToList(array $parameters, Request $request)
    {
        //paginacion
        $parameters['perPage'] = 8;

        // trae todos los productos que tengan negocios
        array_push($parameters, ['has','business']);

        if($request->filled('offer')) {
            array_push($parameters, ['offer', true]);
        }

        if($request->filled('order')){
            array_push($parameters,['orderBy',$request->input('order')]);
        }else{
            array_push($parameters,['orderBy','last']);
        }

        if($request->filled('search_text')){
            array_push($parameters,['search_text',$request->input('search_text')]);
        }


        return $parameters;
    }
}

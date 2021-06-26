<?php

namespace App\Http\Controllers\Web;

use App\Business;
use App\Http\Resources\Web\BusinessWebResource;
use App\Services\BusinessServiceImpl;
use App\Services\CategoryServiceImpl;
use App\Services\ProviderTypeServiceImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BusinessWebController extends Controller
{
    private $service;
    private $categoryService;
    private $providerTypeService;

    private $prefixRouteWeb = "businesses.";
    private $prefixRouteApi = "api.businesses.";

    private $prefixView = "web.business.";

    public function __construct()
    {
        $this->service = new BusinessServiceImpl();
        $this->categoryService = new CategoryServiceImpl();
        $this->providerTypeService = new ProviderTypeServiceImpl();

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
        $title = "Negocios";
        $description = "";

        $parameters = array(
            'perPage' => 6
        );
        $relationshipNames = array('priceRange','reviews');

        $parameters = $this-> addParametersToList($parameters,$request);

        $businesses = $this->service->findAllWithPagination($parameters,$relationshipNames);

        $businessesResource = BusinessWebResource::collection(collect($businesses->items()));

        $titleFilter = "Nuevos Negocios";

        if($request->filled('provider_type_id')){
            $providerType = $this->providerTypeService->find($request->input('provider_type_id'));
            if($providerType){
                $titleFilter = $providerType->name;
            }
        }

        return view($this->prefixView."list",compact('title','titleFilter','description','businesses','businessesResource'));
    }

    /**
     * Obtiene todos los articulos que tienen a una categoria
     *
     * @param Request $request
     * @param string $slug slug de la categoria
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function getAllByCategorySlug(Request $request,$slug)
    {
        $parametersCategory = array(
            'slug' => $slug,
            'category_type_id' => config('constant.categorytype.business_id')
        );
        $category = $this-> categoryService-> findByParameters($parametersCategory);
        if(!$category){
            abort(404);
        }

        $title = "Negocios - ".$category->name;

        $titleFilter = $title;

        $description = "";

        $relationshipNames = array();
        $parameters =array(['category_id_with_childs','=',$category->id]);

        $parameters = $this-> addParametersToList($parameters,$request);

        $businesses = $this-> service->findAllWithPagination($parameters,$relationshipNames);
        $businessesResource = BusinessWebResource::collection(collect($businesses->items()));

        if($request->filled('provider_type_id')){
            $providerType = $this->providerTypeService->find($request->input('provider_type_id'));
            if($providerType){
                $titleFilter = $category->name." - ".$providerType->name;
            }
        }

        return view($this-> prefixView.'list',compact('title','titleFilter','description','category','businesses','businessesResource'));
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
     * Muestra la pagina del negocio por su slug.
     *
     * @param string $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|\View
     */
    public function showBySlug(string $slug)
    {

        $business = $this->service->findBy('slug',$slug);

        if(!$business){
            abort(404);
        }

        $title = $business->name;
        $description = $business->description;

//        dd('hola1');

        return view($this->prefixView."detail",compact('title','description','business'));
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
        $parameters['perPage'] = 6;

        if($request->filled('price_range')){
            array_push($parameters,['price_range_id',$request->input('price_range')]);
        }

        if($request->filled('latitude')){
            array_push($parameters,['distance',$request->input('distance'),$request->input('latitude'),$request->input('longitude')]);
        }

        if($request->filled('order')){
            array_push($parameters,['orderBy',$request->input('order')]);
        }else{
            array_push($parameters,['orderBy','recommended']);
        }

        if($request->filled('provider_type_id')){
            array_push($parameters,['provider_type_id',$request->input('provider_type_id')]);
        }

        if($request->filled('province_id') && $request->input('province_id') !== 'todas'){
            array_push($parameters,['province_id',$request->input('province_id')]);
        }

        if($request->filled('search_text')){
            array_push($parameters,['search_text',$request->input('search_text')]);
        }

        return $parameters;
    }


}

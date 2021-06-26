<?php

namespace App\Http\Controllers\Admin;

use App\Business;
use App\Helpers\ModalMessageHelper;
use App\Http\Requests\Admin\BusinessFormAdminRequest;
use App\Http\Requests\Admin\BusinessProfileFormAdminRequest;
use App\Services\BusinessServiceImpl;
use App\Services\CategoryServiceImpl;
use App\Services\PriceRangeServiceImpl;
use App\Services\ProviderTypeServiceImpl;
use App\Services\UserServiceImpl;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BusinessAdminController extends Controller
{

    private $service;
    private $userService;
    private $categoryService;
    private $priceRangeService;
    private $providerTypeService;

    private $prefixRouteWeb = "admin.businesses.";
    private $prefixRouteApi = "api.admin.businesses.";

    private $prefixView = "admin.business.";

    public function __construct()
    {
        $this->service = new BusinessServiceImpl();
        $this->userService = new UserServiceImpl();
        $this->categoryService = new CategoryServiceImpl();
        $this->priceRangeService = new PriceRangeServiceImpl();
        $this->providerTypeService = new ProviderTypeServiceImpl();

        // cambia el prefix cuando esta dentro del negocio
        if(\Request::is('businesses-admin/*')){
            $this-> prefixRouteWeb = "businesses_admin.products.";
        }

        view()->share('prefixRouteWeb', $this-> prefixRouteWeb);
        view()->share('prefixRouteApi', $this-> prefixRouteApi);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $title = "Lista de negocios";
        return view($this-> prefixView.'list',compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $title = "Registrar negocio";
        $model = new Business();

        return view($this-> prefixView.'form',compact('title','model'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BusinessFormAdminRequest $request)
    {
        $message = array();

        $validated = $request->validated();
        $business = null;
        try{
            $business = $this-> service-> create($validated);

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

        return redirect()->route($this->prefixRouteWeb.'edit',[$business])
            ->with(['modalMessage'=>$modalMessage]);
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(Business $business)
    {
        $title = "Editar negocio";
        $model = $business;

        return view($this-> prefixView.'form',compact('title','model'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Business  $business
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BusinessFormAdminRequest $request, Business $business)
    {
        $message = array();

        $validated = $request->validated();
        $validated['id'] = $business-> id;

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
     * @param  \App\Business  $business
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Business $business)
    {
        $message = array();

        try{
            $this-> service-> delete($business);
        }catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());
            array_push ( $message , trans('crud.delete_error'));
            return redirect()->back()
                ->withInput()
                ->with(['modalMessage'=>ModalMessageHelper::error($message)]);
        }

        $modalMessage = ModalMessageHelper::success([trans('crud.delete_success')]);

        return redirect()->route($this->prefixRouteWeb.'index')
            ->with(['modalMessage'=>$modalMessage]);
    }

    /**
     * Muestra el formulario para crear o editar el perfil del usuario autenticado
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function createOrEditForAuthUser()
    {
        $authUser  = Auth::user();

        $title = "";
        $model = null;

        if($authUser-> business){
            $title = "Actualizar mi negocio";
            $model = $authUser-> business;
        }else{
            $title = "Registrar mi negocio";
            $model = new Business();
        }

        return view($this-> prefixView.'form-profile',compact('title','model'));
    }

    /**
     * Actualiza o guarda los datos del perfil del negocio de un usuario autenticado
     *
     * @param BusinessProfileFormAdminRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeOrUpdateForAuthUser(BusinessProfileFormAdminRequest $request)
    {
        $message = array();

        $authUser = Auth::user();

        $validated = $request->validated();

        try{
            if($authUser->business){
                $validated['id'] = $authUser->business->id;
                $this-> service-> update($validated);
            }else{
                $validated['user_id'] = $authUser->id;
                $this-> service-> create($validated);
            }

        }catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());
            array_push($message, $authUser->business ? trans('crud.update_error') : trans('crud.store_error'));

            return redirect()->back()
                ->withInput()
                ->with(['modalMessage'=>ModalMessageHelper::error($message)]);
        }

        $modalMessage = ModalMessageHelper::success([
            $authUser->business ? trans('crud.update_success') : trans('crud.store_success')
        ]);
        return redirect()
            ->route('businesses_admin.businesses.profile.create_edit')
            ->with(['modalMessage'=>$modalMessage]);
    }

}

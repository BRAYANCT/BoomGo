<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\SendEmailException;
use App\Helpers\ModalMessageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserFormAdminRequest;
use App\Http\Requests\Admin\UserProfileFormAdminRequest;
use App\Services\RoleServiceImpl;
use App\Services\UserServiceImpl;
use App\Services\UserStateServiceImpl;
use App\User;
use Illuminate\Http\Request;

class UserAdminController extends Controller
{

    private $roleService;
    private $service;
    private $userStateService;
    private $prefixRouteWeb = "admin.users.";
    private $prefixRouteApi = "api.admin.users.";

    private $prefixView = "admin.user.";

    public function __construct()
    {
        $this-> roleService = new RoleServiceImpl();
        $this-> service = new UserServiceImpl();
        $this-> userStateService = new UserStateServiceImpl();

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
        $title = "Lista de usuarios";
        return view($this-> prefixView.'list',compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $title = "Registrar usuario";
        $model = new User();

        $roles = $this-> roleService-> findAllAllowedForAuthUser();

        return view($this-> prefixView.'form',compact('title','model','roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserFormAdminRequest $request)
    {
        $message = array();

        $validated = $request->validated();
        $user = null;
        try{
            $user = $this-> service-> create($validated);

        }catch(\Exception $e){
            report($e);
            if($e instanceof SendEmailException){

                $user = $e->getData();
                $modalMessage = ModalMessageHelper::warning([trans('crud.store_success_email_fail')]);

                return redirect()->route($this->prefixRouteWeb.'edit',[$user])
                                    ->with(['modalMessage'=>$modalMessage]);
            }else{
                array_push ( $message , $e->getMessage());
            }

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        $title = "Editar usuario";
        $model = $user;
        $roles = $this-> roleService-> findAllAllowedForAuthUser();
        $userStates = $this-> userStateService-> findAll();

        return view($this-> prefixView.'form',compact('title','model','roles','userStates'));
    }

    /**
     * Update the specified resource in storage.
     * Tiene un middleware para verificar si el usuario autenticado puede realizar una accion sobre el usuario a actualizar
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserFormAdminRequest $request, User $user)
    {
        $message = array();

        $validated = $request->validated();
        $validated['id'] = $user-> id;

        try{

            $this-> service-> update($validated);

        }catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());

            array_push ( $message , trans('crud.update_error'));

            return redirect()->back()
                        ->withInput()
                        ->with(['modalMessage'=> ModalMessageHelper::error($message)]);
        }

        $modalMessage = ModalMessageHelper::success([trans('crud.update_success')]);

        return redirect()->route($this->prefixRouteWeb.'edit',[$user])
                                ->with(['modalMessage'=>$modalMessage]);
    }

    /**
     * Remove the specified resource from storage.
     * Tiene un middleware para verificar si el usuario autenticado puede realizar una accion sobre el usuario a eliminar
     * @param  App\User
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $message = array();

        try{

            $this-> service-> delete($user);

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
     * Muestra el formulario con los datos del perfil a actualizar
     *
     * @return \Illuminate\Http\Response
     */
    public function editProfile()
    {
        $title = "Mi perfil";
        $model = \Auth::user();
        return view($this-> prefixView.'form-profile',compact('title','model'));
    }


    /**
     * Actualiza los datos
     *
     * @param  \Illuminate\Http\UsuarioPerfilFormAdminRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(UserProfileFormAdminRequest $request)
    {
        $message = array();

        $validated = $request->validated();
        $validated['id'] = \Auth::user()-> id;


        try{

            $this-> service-> update($validated);

        }catch(\Exception $e){
            report($e);
            array_push ( $message , $e->getMessage());

            array_push ( $message , trans('crud.update_error'));
            return redirect()->back()
                        ->withInput()
                        ->with(['modalMessage'=>ModalMessageHelper::error($message)]);

        }

        $modalMessage = ModalMessageHelper::success([trans('crud.update_success')]);
        return redirect()->route($this-> prefixRouteWeb.'profile.edit')
                            ->with(['modalMessage'=>$modalMessage]);

    }
}

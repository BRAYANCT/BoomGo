<?php


namespace App\Services;


use App\Business;
use App\OrderGroup;
use App\Repositories\OrderGroupRepositoryImpl;
use App\ShoppingCart;
use App\User;
use Illuminate\Support\Facades\Auth;

class OrderGroupServiceImpl extends GenericServiceImpl implements IOrderGroupService
{

    public function __construct()
    {
        $this-> repository = new OrderGroupRepositoryImpl();
    }


    /**
     * Guarda el registro en la base de datos con todas sus relaciones y crea el usuario con los datos enviados
     *
     * @param array $data
     * @param UserServiceImpl $userService
     * @param ShoppingCart $shoppingCart
     * @return OrderGroup
     * @throws \App\Exceptions\DataBaseGenericException
     */
    public function createComplete($data,UserServiceImpl $userService,ShoppingCart $shoppingCart)
    {
        \DB::beginTransaction();
        $orderGroup = null;
        try {

            //  si no esta loguea crea el usuario con los datos enviados
            if(Auth::check()){
                $user = Auth::user();
            }else{
                $dataCreateUser = array(
                    'names' => $data['email'],
                    'surnames' => $data['surnames'],
                    'email' => $data['email'],
                );
                $user = $userService->createFromPublicForm($dataCreateUser);
            }

            //guarda el usuario
            $orderGroup = $this-> repository-> createComplete($data,$user,$shoppingCart);

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        return $orderGroup;
    }


    /**
     * Guarda el registro en la base de datos con todas sus relaciones para un negocio y crea el usuario con los datos enviados
     *
     * @param Business $business
     * @param array $data
     * @param UserServiceImpl $userService
     * @param ShoppingCart $shoppingCart
     * @return OrderGroup
     * @throws \App\Exceptions\DataBaseGenericException
     */
    public function createCompleteByBusiness(Business $business,$data,UserServiceImpl $userService,ShoppingCart $shoppingCart)
    {
        \DB::beginTransaction();
        $orderGroup = null;
        try {

            //  si no esta loguea crea el usuario con los datos enviados
            if(Auth::check()){
                $user = Auth::user();
            }else{
                $dataCreateUser = array(
                    'names' => $data['email'],
                    'surnames' => $data['surnames'],
                    'email' => $data['email'],
                );
                $user = $userService->createFromPublicForm($dataCreateUser);
            }

            //guarda el usuario
            $orderGroup = $this-> repository-> createCompleteByBusiness($business,$data,$user,$shoppingCart);

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        return $orderGroup;
    }

}

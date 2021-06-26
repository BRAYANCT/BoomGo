<?php


namespace App\Services;


use App\Business;
use App\OrderGroup;
use App\ShoppingCart;

interface IOrderGroupService
{
    /**
     * Guarda el registro en la base de datos con todas sus relaciones y crea el usuario con los datos enviados
     *
     * @param array $data
     * @param UserServiceImpl $userService
     * @param ShoppingCart $shoppingCart
     * @return OrderGroup
     * @throws \App\Exceptions\DataBaseGenericException
     */
    public function createComplete($data,UserServiceImpl $userService,ShoppingCart $shoppingCart);

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
    public function createCompleteByBusiness(Business $business,$data,UserServiceImpl $userService,ShoppingCart $shoppingCart);

}

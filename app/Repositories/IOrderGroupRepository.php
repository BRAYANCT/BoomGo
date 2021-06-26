<?php


namespace App\Repositories;


use App\Business;
use App\Exceptions\DataBaseGenericException;
use App\OrderGroup;
use App\ShoppingCart;
use App\User;

interface IOrderGroupRepository
{
    /**
     * Guarda el registro en la base de datos con todas sus relaciones y crea el usuario con los datos enviados
     *
     * @param array $data
     * @param User $user
     * @param ShoppingCart $shoppingCart
     * @return OrderGroup
     * @throws DataBaseGenericException
     */
    public function createComplete($data,User $user,ShoppingCart $shoppingCart);

    /**
     * Guarda el registro en la base de datos con todas sus relaciones para un negocio
     *
     * @param Business $business
     * @param array $data
     * @param User $user
     * @param ShoppingCart $shoppingCart
     * @return OrderGroup
     * @throws DataBaseGenericException
     */
    public function createCompleteByBusiness(Business $business,$data,User $user,ShoppingCart $shoppingCart);
}

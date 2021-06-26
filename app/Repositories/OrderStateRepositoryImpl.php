<?php


namespace App\Repositories;


use App\OrderState;

class OrderStateRepositoryImpl extends GenericRepositoryImpl implements IOrderStateRepository
{

    public function __construct()
    {
        $this-> model = new OrderState();
    }

}

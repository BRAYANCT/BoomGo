<?php


namespace App\Services;


use App\Repositories\OrderStateRepositoryImpl;

class OrderStateServiceImpl extends GenericServiceImpl implements IOrderStateService
{

    public function __construct()
    {
        $this-> repository = new OrderStateRepositoryImpl();
    }

}

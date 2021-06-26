<?php


namespace App\Services;


use App\Repositories\PriceRangeRepositoryImpl;

class PriceRangeServiceImpl  extends GenericServiceImpl implements IPriceRangeService
{


    public function __construct()
    {
        $this-> repository = new PriceRangeRepositoryImpl();
    }

}

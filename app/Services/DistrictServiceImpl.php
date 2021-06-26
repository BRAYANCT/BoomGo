<?php


namespace App\Services;


use App\Repositories\DistrictRepositoryImpl;

class DistrictServiceImpl extends GenericServiceImpl implements IDistrictService
{

    public function __construct()
    {
        $this-> repository = new DistrictRepositoryImpl();
    }

}

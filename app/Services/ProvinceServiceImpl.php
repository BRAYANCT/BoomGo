<?php


namespace App\Services;


use App\Repositories\ProvinceRepositoryImpl;

class ProvinceServiceImpl extends GenericServiceImpl implements IProvinceService
{

    public function __construct()
    {
        $this-> repository = new ProvinceRepositoryImpl();
    }

}

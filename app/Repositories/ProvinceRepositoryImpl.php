<?php


namespace App\Repositories;


use App\Province;

class ProvinceRepositoryImpl extends GenericRepositoryImpl implements IProvinceRepository
{

    public function __construct()
    {
        $this-> model = new Province();
    }

}

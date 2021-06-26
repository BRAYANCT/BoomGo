<?php


namespace App\Repositories;


use App\District;

class DistrictRepositoryImpl extends GenericRepositoryImpl implements IDistrictRepository
{

    public function __construct()
    {
        $this-> model = new District();
    }

}

<?php


namespace App\Services;


use App\Repositories\ClaimRepositoryImpl;

class ClaimServiceImpl extends GenericServiceImpl implements IClaimService
{

    public function __construct()
    {
        $this-> repository = new ClaimRepositoryImpl();
    }

}

<?php


namespace App\Repositories;


use App\Claim;

class ClaimRepositoryImpl extends GenericRepositoryImpl implements IClaimRepository
{

    public function __construct()
    {
        $this-> model = new Claim();
    }

}

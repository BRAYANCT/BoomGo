<?php


namespace App\Repositories;


use App\PriceRange;

class PriceRangeRepositoryImpl extends GenericRepositoryImpl implements IPriceRangeRepository
{

    public function __construct()
    {
        $this-> model = new PriceRange();
    }

}

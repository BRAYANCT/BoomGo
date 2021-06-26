<?php


namespace App\Services;


use App\Repositories\ProviderTypeRepositoryImpl;

class ProviderTypeServiceImpl extends GenericServiceImpl implements IProviderTypeService
{

    public function __construct()
    {
        $this-> repository = new ProviderTypeRepositoryImpl();
    }

}

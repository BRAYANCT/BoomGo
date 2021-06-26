<?php


namespace App\Repositories;


use App\ProviderType;

class ProviderTypeRepositoryImpl extends GenericRepositoryImpl implements IProviderTypeRepository
{

    public function __construct()
    {
        $this-> model = new ProviderType();
    }

}

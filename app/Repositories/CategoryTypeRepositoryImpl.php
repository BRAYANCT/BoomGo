<?php


namespace App\Repositories;


use App\CategoryType;

class CategoryTypeRepositoryImpl extends GenericRepositoryImpl implements ICategoryTypeRepository
{

    public function __construct()
    {
        $this-> model = new CategoryType();
    }

}

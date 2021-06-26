<?php


namespace App\Services;


use App\Repositories\CategoryTypeRepositoryImpl;

class CategoryTypeServiceImpl extends GenericServiceImpl implements ICategoryTypeService
{

    public function __construct()
    {
        $this-> repository = new CategoryTypeRepositoryImpl();
    }

}

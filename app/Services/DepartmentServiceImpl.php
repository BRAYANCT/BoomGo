<?php


namespace App\Services;


use App\Repositories\DepartmentRepositoryImpl;

class DepartmentServiceImpl extends GenericServiceImpl implements IDepartmentService
{

    public function __construct()
    {
        $this-> repository = new DepartmentRepositoryImpl();
    }

}

<?php


namespace App\Repositories;


use App\Department;

class DepartmentRepositoryImpl extends GenericRepositoryImpl implements IDepartmentRepository
{

    public function __construct()
    {
        $this-> model = new Department();
    }

}

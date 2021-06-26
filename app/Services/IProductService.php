<?php


namespace App\Services;


use Illuminate\Support\Collection;

interface IProductService
{


    /**
     * Obtiene la lista de productos que tiene permitido ver el usuario authenticado segun su role
     * de nivel superior
     *
     * @param array $parameters
     * @param array $relationshipNames
     * @param bool $trashed
     * @return collection Product::class
     */
    public function findAllAllowedForAuthUser($parameters=[],$relationshipNames=[],$trashed = false);

}

<?php


namespace App\Repositories;


use App\Business;
use App\District;
use App\Shipping;
use Illuminate\Support\Collection;

interface IShippingRepository
{
    /**
     * Obtiene la lista de envios que tiene permitido ver el usuario authenticado segun su role de nivel superior
     *
     * @param array $parameters
     * @param array $relationshipNames
     * @param bool $trashed
     * @return collection Shipping::class
     */
    public function findAllAllowedForAuthUser($parameters=[],$relationshipNames=[],$trashed = false);


    /**
     * Obtiene el envio de un negocio priorizando el distrito y si no encuentra agarra la provincia y luego el departamento
     *
     * @param Business $business
     * @param District $district
     * @return Shipping
     */
    public function findByBusinessAndPriorityDistrict(Business $business,District $district);

}

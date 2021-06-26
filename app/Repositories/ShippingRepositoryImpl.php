<?php


namespace App\Repositories;


use App\Business;
use App\Department;
use App\District;
use App\Province;
use App\Shipping;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ShippingRepositoryImpl extends GenericRepositoryImpl implements IShippingRepository
{


    public function __construct()
    {
        $this-> model = new Shipping();

    }

    /**
     * Obtiene la lista de envios que tiene permitido ver el usuario authenticado segun su role de nivel superior
     *
     * @param array $parameters
     * @param array $relationshipNames
     * @param bool $trashed
     * @return collection Shipping::class
     */
    public function findAllAllowedForAuthUser($parameters=[],$relationshipNames=[],$trashed = false)
    {
        //Obtiene el usuario autenticado
        $authUser = Auth::user();

        $query = $this-> model;

        $query = $this->getRelationshipQuery($relationshipNames,$query);

        if($trashed){
            $query = $query->withTrashed();
        }

        // si no es administrador del sistema
        if(!$authUser->canChooseBusiness()){
            $query = $query->where('business_id',$authUser->business ? $authUser->business->id : -1 );
        }

        $query = $this->getParametersQuery($parameters,$query);
        return $query ->get();
    }



    /**
     * Obtiene el envio de un negocio priorizando el distrito y si no encuentra agarra la provincia y luego el departamento
     *
     * @param Business $business
     * @param District $district
     * @return Shipping
     */
    public function findByBusinessAndPriorityDistrict(Business $business,District $district)
    {
        return $business->getShippingPriorityDistrict($district);
    }

}

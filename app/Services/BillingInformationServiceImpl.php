<?php


namespace App\Services;


use App\BillingInformation;
use App\Repositories\BillingInformationRepositoryImpl;

class BillingInformationServiceImpl extends GenericServiceImpl implements IBillingInformationService
{

    public function __construct()
    {
        $this-> repository = new BillingInformationRepositoryImpl();
    }

    /**
     * Obtiene el ultimo registro del usuario atenticado
     *
     * @param  array $relationshipNames Nombres de las relaciones que se traera
     * @param  boolean $trashed
     * @return BillingInformation
     */
    public function findLastForAuthUser($relationshipNames=[],$trashed = false)
    {
        $authUser = \Auth::user();
        return $this-> repository->findLastByUser($authUser,$relationshipNames,$trashed);
    }

}

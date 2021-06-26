<?php


namespace App\Repositories;


use App\BillingInformation;
use App\User;

interface IBillingInformationRepository
{


    /**
     * Obtiene el ultimo registro del usuario enviado
     *
     * @param User $user
     * @param array $relationshipNames Nombres de las relaciones que se traera
     * @param boolean $trashed
     * @return BillingInformation
     */
    public function findLastByUser(User $user,$relationshipNames=[],$trashed = false);

}

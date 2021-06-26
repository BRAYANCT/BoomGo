<?php


namespace App\Repositories;


use App\BillingInformation;
use App\User;

class BillingInformationRepositoryImpl extends GenericRepositoryImpl implements IBillingInformationRepository
{

    public function __construct()
    {
        $this-> model = new BillingInformation();
    }

    /**
     * Obtiene el ultimo registro del usuario enviado
     *
     * @param User $user
     * @param array $relationshipNames Nombres de las relaciones que se traera
     * @param boolean $trashed
     * @return BillingInformation
     */
    public function findLastByUser(User $user,$relationshipNames=[],$trashed = false)
    {
        $query = $this-> model;

        $query = $this->getRelationshipQuery($relationshipNames,$query);

        if($trashed){
            $query = $query->withTrashed();
        }

        return $query->whereHas('orderGroup', function ($query) use($user){
                    $query->where('order_groups.user_id',$user->id);
                })
                ->orderBy('billing_information.created_at','desc')
                ->first();
    }
}

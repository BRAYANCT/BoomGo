<?php 
namespace App\Repositories;

use App\Repositories\GenericRepositoryImpl;
use App\Repositories\IRoleRepository;
use App\Role;
use Illuminate\Support\Facades\Auth;

class RoleRepositoryImpl extends GenericRepositoryImpl implements IRoleRepository
{

    public function __construct()
    {
        $this-> model = new Role();
    }


    /**
     * Obtiene todos los roles que puede ver el usuario authenticado.
     *
     * @param array $parameters
     * @param array $relationshipNames
     * @param bool $trashed
     * @return \App\Repositories\Illuminate\Support\Collection Role::class
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
        if(!$authUser->isAdminSys()){
            $query = $query ->whereNotIn('name', [config('constant.role.ADMIN_SYS')]);
        }

        foreach ($parameters as $key => $value) {
            if(!empty($value)){
                $query = $query-> where($key,$value);
            }
        }
        return $query ->get();
    }


}
?>
<?php
namespace App\Repositories;

use App\Exceptions\DataBaseGenericException;
use App\Repositories\GenericRepositoryImpl;
use App\Repositories\IUserRepository;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserRepositoryImpl extends GenericRepositoryImpl implements IUserRepository
{

    public function __construct()
    {
        $this-> model = new User();
    }


        /**
     * Obtiene la lista de usuarios que tiene permitido ver el usuario authenticado segun su role
     * de nivel superior
     *
     * @param array $parameters
     * @param array $relationshipNames
     * @param bool $trashed
     * @return collection User::class
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
            $query = $query
                ->whereDoesntHave('roles', function (Builder $query){
                    $query->where('roles.name', config('constant.role.ADMIN_SYS'));
                });
        }

        $query = $this->getParametersQuery($parameters,$query);

        return $query ->get();
    }

    /**
     * Obtiene todos los usuarios que tienen los nombres de los roles enviados.
     *
     * @param array $roleNames
     * @return collection User::class
     */
    public function findAllWhereHasRolesWhereInNames($roleNames,$relationshipNames=[],$trashed = false){

        $query = $this-> model;

        if(count($relationshipNames) > 0) {
            $query = $query-> with($relationshipNames);
        }

        if($trashed){
            $query = $query->withTrashed();
        }

        return $query
                    ->whereHas('roles', function (Builder $query) use($roleNames) {
                        $query->whereIn('roles.name', $roleNames);
                    })
                    ->get();
    }

    /**
     * Obtiene todos los usuarios que tienen los nombres de los roles enviados.
     *
     * @param array $roleNames
     * @return collection User::class
     */
    public function findAllWhereDoesntHaveRolesWhereInNames($roleNames,$relationshipNames=[],$trashed = false){

        $query = $this-> model;

        if(count($relationshipNames) > 0) {
            $query = $query-> with($relationshipNames);
        }

        if($trashed){
            $query = $query->withTrashed();
        }

        return $query
                    ->whereDoesntHave('roles', function (Builder $query) use($roleNames) {
                        $query->whereIn('roles.name', $roleNames);
                    })
                    ->get();
    }


    /**
     * Sincroniza un role al usuario
     *
     * @param User:class $user
     * @param integer $roleId
     * @return boolean
     */
    public function syncRole($user,$roleId){
        try {
            $user->roles()->sync($roleId);
        }catch (\Exception $e) {
            throw new DataBaseGenericException($e->getMessage());
        }
        return true;
    }

}
?>

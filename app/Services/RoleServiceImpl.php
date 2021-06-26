<?php
namespace App\Services;

use App\Repositories\RoleRepositoryImpl;
use App\Services\GenericServiceImpl;
use App\Services\IRoleService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class RoleServiceImpl extends GenericServiceImpl implements IRoleService
{


 	public function __construct()
    {
    	$this-> repository = new RoleRepositoryImpl();
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
        return $this->repository->findAllAllowedForAuthUser($parameters,$relationshipNames,$trashed);
    }
}
?>

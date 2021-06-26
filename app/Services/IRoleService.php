<?php 
namespace App\Services; 


interface IRoleService{
	
	/**
     * Obtiene todos los roles que puede ver el usuario authenticado.
     *
     * @param array $parameters
     * @param array $relationshipNames
     * @param bool $trashed
     * @return \App\Repositories\Illuminate\Support\Collection Role::class
     */
    public function findAllAllowedForAuthUser($parameters=[],$relationshipNames=[],$trashed = false);


  
}
?>
<?php 
namespace App\Repositories; 


interface IUserRepository{
	

    /**
     * Obtiene la lista de usuarios que tiene permitido ver el usuario authenticado segun su role
     * de nivel superior
     *
     * @param array $parameters
     * @param array $relationshipNames
     * @param bool $trashed
     * @return collection User::class
     */
    public function findAllAllowedForAuthUser($parameters=[],$relationshipNames=[],$trashed = false);

    /**
     * Obtiene todos los usuarios que tienen los nombres de los roles enviados.
     *
     * @param Array $roleNames 
     * @return collection User::class
     */
    public function findAllWhereHasRolesWhereInNames($roleNames,$relationshipNames=[],$trashed = false);


    /**
     * Obtiene todos los usuarios que no tienen los nombres de los roles enviados.
     *
     * @param Array $roleNames 
     * @return collection User::class
     */
    public function findAllWhereDoesntHaveRolesWhereInNames($roleNames,$relationshipNames=[],$trashed = false);


    /**
     * Sincroniza un role al usuario
     * @param User:class $user
     * @param integer $roleId
     * @return boolean
     */
    public function syncRole($user,$roleId);
}
?>
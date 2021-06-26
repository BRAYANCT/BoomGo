<?php 
namespace App\Services; 


interface IUserService{
	

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
     * Genera el username a partir del email
     * 
     * @param  String $email
     * @return String
    */
    public function generateUsername($email);

    /**
     * Genera un api token
     * 
     * @return String
    */
    public function generateApiToken();

    /**
     * Genera un password aleatorio
     * 
     * @return String
    */
    public function generatePassword();


    /**
     * Genera un password encriptado
     * 
     * @return string
     */
    public function generatePasswordEncrypt();


}
?>
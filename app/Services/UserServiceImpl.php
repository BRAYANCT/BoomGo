<?php
namespace App\Services;

use App\Exceptions\SendEmailException;
use App\Notifications\User\UserRegisterNotification;
use App\Repositories\UserRepositoryImpl;
use App\Services\GenericServiceImpl;
use App\Services\IUserService;
use App\Utils\Services\ImageServiceImpl;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class UserServiceImpl extends GenericServiceImpl implements IUserService
{

    private $imageService;

    public function __construct()
    {
        $this-> repository = new UserRepositoryImpl();
        $this-> imageService = new ImageServiceImpl();
    }


    /**
     * This is an overriden method from GenericServiceImpl class.
     * Guarda el registro en la base de datos
     *
     * @param array $data
     * @return User::class
    */
    public function create($data)
    {
        \DB::beginTransaction();
        $user = null;
        try {

            $password = "";

            //Se registra un password
            if(filter_var($data['cambio_password'], FILTER_VALIDATE_BOOLEAN)){
                $password = $data['password'];
                $data['password'] = bcrypt($password);
            // se genera el password de forma automatica;
            }else{
                $password = $this->generatePassword();
                $data['password'] = bcrypt($password);
            }

            // se genera el usuario de forma automatica
            if(empty($data['username'])){
                $data['username'] = $this->generateUsername($data['email']);
            }

            // se crea el api token
            $data['api_token'] = $this->generateApiToken();

            // se genera el nombre de la imagen y guarda en lo parametros
            $data['profile_picture'] = $this-> imageService-> generateName();


            //guarda el usuario
            $user = $this-> repository-> create($data);

            // sincroniza los roles
            $this-> repository-> syncRole($user,$data['role_id']);

            //guarda el avatar del usuario
            $this-> imageService-> saveAvatarImage($user-> full_name,$this->getStorageName(true),$user-> profile_picture);

            $dataNotificacion = array();
            $dataNotificacion['password'] = $password;
            $when = now()->addSeconds(30);
            $user->notify((new UserRegisterNotification($dataNotificacion))->delay($when));


            \DB::commit();

        } catch (\Exception $e) {
            // ingresa cuando el correo electronico falla
            if($e instanceof \Swift_SwiftException){
                \DB::commit();
                Log::error('No se pudo enviar el correo al momento de registrar un usuario');
                throw new SendEmailException($e->getMessage(),$user);
            }

            \DB::rollBack();
            throw $e;
        }

        return $user;
    }


    /**
     *
     * Crea un registro con los datos del formulario publico
     * @param array $data
     * @return User::class
     */
    public function createFromPublicForm($data)
    {
        \DB::beginTransaction();
        $user = null;
        try {

            if(isset($data['password'])){
                $password = $data['password'];
            }else{
                $password = $this->generatePassword();
            }

            $data['password'] = bcrypt($password);

            // se genera el usuario de forma automatica
            if(empty($data['username'])){
                $data['username'] = $this->generateUsername($data['email']);
            }

            // se crea el api token
            $data['api_token'] = $this->generateApiToken();

            // se genera el nombre de la imagen y guarda en lo parametros
            $data['profile_picture'] = $this-> imageService-> generateName();


            //guarda el usuario
            $user = $this-> repository-> create($data);

            // Pone el rol de comensal
            $this-> repository-> syncRole($user,config('constant.role.CUSTOMER_ID'));


            //guarda el avatar del usuario
            $this-> imageService-> saveAvatarImage($user-> full_name,$this->getStorageName(true),$user-> profile_picture);

            $dataNotification = array();
            $dataNotification['password'] = $password;
            $when = now()->addSeconds(30);
            $user->notify((new UserRegisterNotification($dataNotification))->delay($when));

            \DB::commit();

        } catch (\Exception $e) {

            // ingresa cuando el correo electronico falla
            if($e instanceof \Swift_SwiftException){
                \DB::commit();
                Log::error('No se pudo enviar el correo al momento de registrar un usuario');
//                throw new SendEmailException($e->getMessage(),$user);
            }else{
                \DB::rollBack();
                throw $e;
            }
        }
        return $user;
    }

    /**
     * This is an overriden method from GenericServiceImpl class.
     * Actualiza un registro
     *
     * @param array $data Arreglo con los datos a actualizar
     * @return User:class
    */
    public function update($data)
    {
        \DB::beginTransaction();
        $user = null;
        try {


            $image = null;
            $nameOldImage = "";
            //Cuando envia una imagen
            if(isset($data['image'])){
                //obtiene el nombre de la imagen anterior para ser borrado
                $nameOldImage = $this-> repository->find($data['id'])-> profile_picture;

                $image = $data['image'];
                //Genera el nombre de la nueva imagen a insertar
                $data['profile_picture'] = $this-> imageService-> generateName($image->getClientOriginalName());
            }

            //Si el cambio de password está activo encripta la contraseña
            if(filter_var($data['cambio_password'], FILTER_VALIDATE_BOOLEAN)){
                $password = $data['password'];
                $data['password'] = bcrypt($password);
            }

            //guarda el usuario
            $user = $this-> repository-> update($data);

            // sincroniza los roles
            if(isset($data['role_id'])){
                // sincroniza los roles
                $this-> repository-> syncRole($user,$data['role_id']);
            }

            // Elimina y guarda la nueva imagen en el storage
            if($image){

                //guarda la imagen en el storage
                $this-> imageService-> saveInterventionImg($image,$user-> profile_picture,$this->getStorageName(true),70);

                //Borra la imagen anterior del storage
                $this-> imageService-> removeStorage($nameOldImage,$this->getStorageName(true));

            }

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        return $user;
    }


    /**
     * This is an overriden method from GenericServiceImpl class.
     * Borra un registro
     *
     * @param  User::class $user
     * @return boolean
    */
    public function delete($user)
    {
        \DB::beginTransaction();
        $result = false;

        try {
            //borra el usuario
            $result = $this-> repository-> delete($user);

            if($result){
                //Borra la imagen del storage
                if(!empty($user-> profile_picture)){
                    $this-> imageService-> removeStorage($user-> profile_picture,$this->getStorageName(true));
                }

                \DB::commit();

            }else{
                \DB::rollBack();
            }

        }catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        return true;
    }



    /**
     * Borra uno o mas registro por el id
     *
     * @param  array integer $arrayIds
     * @return boolean
    */
    public function destroy($arrayIds)
    {

        \DB::beginTransaction();
        try {

            //obtiene todos los registro a borrar
            $users = $this-> repository -> findAllByIdArray($arrayIds);

            //obtiene las imagenes quita de la coleccion los que no tienen imagenes y los ponen dentro de un arreglo
            $imagesDelete = $users->pluck('profile_picture')->filter()->all();

            // borra los usuarios
            $this-> repository-> destroy($arrayIds);

            // borra las imagenes de los usuarios
            $this-> imageService-> removeStorageArray($imagesDelete,$this->getStorageName(true));

            \DB::commit();
        }catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        return true;
    }


    /**
     * Obtiene el nombre del storage
     *
     * @param bool $public
     * @return string
     */
    public function getStorageName($public = false)
    {
        if($public){
            return config("constant.image.storage_public")."/".config("constant.image.user.storage");
        }
        return config("constant.image.user.storage");
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
        return $this->repository->findAllAllowedForAuthUser($parameters,$relationshipNames,$trashed);
    }


    /**
     * Obtiene la lista de usuarios que puedan registrar un negocio
     *
     *
     * @param array $parameters
     * @param array $relationshipNames
     * @param bool $trashed
     * @return collection User::class
     */
    public function findAllCanRegisterBusiness($parameters=[],$relationshipNames=[],$trashed = false)
    {
        array_push($parameters,['doesntHave','business']);
        return $this->repository->findAllAllowedForAuthUser($parameters,$relationshipNames,$trashed);
    }


    /**
     * Genera el username a partir del email
     *
     * @param  String $email
     * @return String
    */
    public function generateUsername($email)
    {

        $arrayEmail = preg_split("/@/", $email);
        $username = $arrayEmail[0];

        $usuarioVerifica = $this-> repository-> findBy('username',$username,[],true);
        // Log::debug($usuarioVerifica);
        //si el username existe se concatena un numero
        if($usuarioVerifica){
            // se realiza un for para generar un username
            for($i=0 ;$i<20; $i++){

                $usernameNum = $username.($i+1);

                $usuarioVerifica = $this-> repository-> findBy('username',$usernameNum,[],true);
                // si el username no existe finaliza el bucle
                if(!$usuarioVerifica){
                    $username = $usernameNum;
                    break;
                }
            }
        }
        return $username;
    }

    /**
     * Genera un api token
     *
     * @return String
    */
    public function generateApiToken()
    {
        return Str::random(60);
    }

    /**
     * Genera un password aleatorio
     *
     * @return String
    */
    public function generatePassword()
    {
        return Str::random(10);
    }

    /**
     * Genera un password encriptado
     *
     * @return string
     */
    public function generatePasswordEncrypt()
    {
        return bcrypt($this->generatePassword());
    }


}
?>

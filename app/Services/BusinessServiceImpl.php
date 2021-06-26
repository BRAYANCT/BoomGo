<?php


namespace App\Services;


use App\Business;
use App\Helpers\UrlHelper;
use App\Repositories\BusinessRepositoryImpl;
use App\Repositories\UserRepositoryImpl;
use App\Utils\Services\ImageServiceImpl as ImageUtilServiceImpl;
use Illuminate\Support\Facades\Auth;

class BusinessServiceImpl extends GenericServiceImpl implements IBusinessService
{

    private $imageUtilService;
    private $userRepository;

    public function __construct()
    {
        $this-> repository = new BusinessRepositoryImpl();
        $this-> imageUtilService = new ImageUtilServiceImpl();
        $this-> userRepository = new UserRepositoryImpl();
    }

    /**
     * This is an overriden method from GenericServiceImpl class.
     * Guarda el registro en la base de datos
     *
     * @param array $data
     * @return Business::class
     */
    public function create($data)
    {
        \DB::beginTransaction();
        $business = null;
        try {

            $logoObject = $data['logo_object'];

            $data['price_range_id'] =  $data['price_range_id'] == '0' ? null : $data['price_range_id'];

            // se genera el nombre de la imagen y guarda en lo parametros
            $data['logo'] = $this-> imageUtilService-> generateName($logoObject->getClientOriginalName());

            $data['slug'] = UrlHelper::generateUniqueSlug( new Business(),$data['name']);

            //guarda el negocio
            $business = $this-> repository-> create($data);

            //guarda la imagen en el storage
            $this-> imageUtilService-> saveInterventionImg($logoObject,$business-> logo,$this->getStorageName(true),70);


            //agrega los tipos de proveedor
            $this->repository->syncProviderTypes($business,$data['provider_types_id']);


            $imageGallery = isset($data['image_gallery']) ? $data['image_gallery'] : null;

            if($imageGallery){
                $this-> insertImageGallery($business,$imageGallery);
            }

            $authUser = Auth::user();

            if($authUser->isCustomer()){
                $this->userRepository->syncRole($business->user,config('constant.role.VENDOR_ID'));
            }

            \DB::commit();

        } catch (\Exception $e) {

            \DB::rollBack();
            throw $e;
        }

        return $business;
    }

    /**
     * This is an overriden method from GenericServiceImpl class.
     * Actualiza un registro
     *
     * @param array $data Arreglo con los datos a actualizar
     * @return Business:class
     * @throws \Exception
     */
    public function update($data)
    {
        \DB::beginTransaction();
        $business = null;
        try {

            $data['price_range_id'] =  $data['price_range_id'] == '0' ? null : $data['price_range_id'];


            $logoObject = null;

            $oldLogoName = "";

            //Cuando envia una imagen
            if(isset($data['logo_object'])){
                //obtiene el nombre de la imagen anterior para ser borrado
                $oldLogoName = $this-> repository->find($data['id'])-> logo;

                $logoObject = $data['logo_object'];
                //Genera el nombre de la nueva imagen a insertar
                $data['logo'] = $this-> imageUtilService-> generateName($logoObject->getClientOriginalName());
            }

            //guarda el negocio
            $business = $this-> repository-> update($data);


            // Elimina y guarda la nueva imagen en el storage
            if($logoObject){

                //guarda la imagen en el storage
                $this-> imageUtilService-> saveInterventionImg($logoObject,$business-> logo,$this->getStorageName(true),70);

                //Borra la imagen anterior del storage
                $this-> imageUtilService-> removeStorage($oldLogoName,$this->getStorageName(true));

            }

            //agrega los tipos de proveedor
            $this->repository->syncProviderTypes($business,$data['provider_types_id']);

            $imageGallery = isset($data['image_gallery']) ? $data['image_gallery'] : null;

            if($imageGallery){
                $this-> insertImageGallery($business,$imageGallery);
            }

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        return $business;
    }

    /**
     * This is an overriden method from GenericServiceImpl class.
     * Obtiene el nombre del storage
     *
     * @param bool $public
     * @return string
     */
    public function getStorageName($public = false)
    {
        if($public){
            return config("constant.image.storage_public")."/".config("constant.image.business.storage");
        }
        return config("constant.image.business.storage");
    }


    /**
     * Registra las imagenes en la base de datos y las guarda en el storage
     *
     * @param Business $business
     * @param array $imageGallery
     * @return boolean
     */
    public function insertImageGallery(Business $business,array $imageGallery)
    {
        \DB::beginTransaction();
        try {

            $imagesName = array();

            foreach ($imageGallery as $index => $imageObject){
                $imageName = $this-> imageUtilService-> generateName($imageObject->getClientOriginalName());
                array_push($imagesName,$imageName);
                $this-> imageUtilService-> saveInterventionImg($imageObject,$imageName,$this->getStorageName(true),70);
            }

            $dataInsertImages = array('images_name'=>$imagesName);
            $this->repository->insertImages($business,$dataInsertImages);

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        return false;
    }

}

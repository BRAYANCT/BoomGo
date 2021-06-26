<?php


namespace App\Services;


use App\Helpers\UrlHelper;
use App\Product;
use App\Repositories\ProductRepositoryImpl;
use App\Utils\Services\ImageServiceImpl as ImageUtilServiceImpl;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Types\Boolean;

class ProductServiceImpl extends GenericServiceImpl implements IProductService
{

    private $imageUtilService;

    public function __construct()
    {
        $this-> repository = new ProductRepositoryImpl();
        $this-> imageUtilService = new ImageUtilServiceImpl();
    }

    /**
     * This is an overriden method from GenericServiceImpl class.
     * Guarda el registro en la base de datos
     *
     * @param array $data
     * @return Product::class
     */
    public function create($data)
    {
        \DB::beginTransaction();
        $product = null;
        try {

            $authUser = Auth::user();

            $isAdminBusiness = isset($data['is_admin_business']) ? $data['is_admin_business'] : false;
            $isAdminBusiness = filter_var($isAdminBusiness, FILTER_VALIDATE_BOOLEAN);

            if(!$authUser->canChooseBusiness() || $isAdminBusiness ){
                $data['business_id'] = $authUser->business->id;
            }

            $pictureObject = $data['picture_object'];

            // se genera el nombre de la imagen y guarda en lo parametros
            $data['picture'] = $this-> imageUtilService-> generateName($pictureObject->getClientOriginalName());


            $data['slug'] = UrlHelper::generateUniqueSlug( new Product(),$data['name']);

            //guarda el negocio
            $product = $this-> repository-> create($data);

            //guarda la imagen en el storage
            $this-> imageUtilService-> saveInterventionImg($pictureObject,$product-> picture,$this->getStorageName(true),70);

            $this->repository->syncCategories($product,$data);

            $imageGallery = isset($data['image_gallery']) ? $data['image_gallery'] : null;

            if($imageGallery){
                $this-> insertImageGallery($product,$imageGallery);
            }



//            if($imageGallery){
//
//                $imagesName = array();
//
//                foreach ($imageGallery as $index => $imageObject){
//                    $imageName = $this-> imageUtilService-> generateName($imageObject->getClientOriginalName());
//                    array_push($imagesName,$imageName);
//                    $this-> imageUtilService-> saveInterventionImg($imageObject,$imageName,$this->getStorageName(true),70);
//                }
//
//                $dataInsertImages = array('images_name'=>$imagesName);
//                $this->repository->insertImages($product,$dataInsertImages);
//
//            }


            \DB::commit();

        } catch (\Exception $e) {

            \DB::rollBack();
            throw $e;
        }

        return $product;
    }


    /**
     * This is an overriden method from GenericServiceImpl class.
     * Actualiza un registro
     *
     * @param array $data Arreglo con los datos a actualizar
     * @return Product
     * @throws \Exception
     */
    public function update($data)
    {
        \DB::beginTransaction();
        $product = null;
        try {

            $authUser = Auth::user();

            $isAdminBusiness = isset($data['is_admin_business']) ? $data['is_admin_business'] : false;
            $isAdminBusiness = filter_var($isAdminBusiness, FILTER_VALIDATE_BOOLEAN);

            if(!$authUser->canChooseBusiness() || $isAdminBusiness ){
                $data['business_id'] = $authUser->business->id;
            }

            $pictureObject = isset($data['picture_object']) ? $data['picture_object'] : null;

            //Cuando envia una imagen
            if($pictureObject){
                //obtiene el producto antes de actualizar
                $oldProduct = $this-> repository->find($data['id']);
                $data['picture'] = $this-> imageUtilService-> generateName($pictureObject->getClientOriginalName());
            }

            //guarda el producto
            $product = $this-> repository-> update($data);

            // Elimina y guarda la nueva imagen en el storage
            if($pictureObject){

                //guarda la imagen en el storage
                $this-> imageUtilService-> saveInterventionImg($pictureObject,$product-> picture,$this->getStorageName(true),70);

                //Borra la imagen anterior del storage
                $this-> imageUtilService-> removeStorage($oldProduct->picture,$this->getStorageName(true));
            }

            $this->repository->syncCategories($product,$data);

            $imageGallery = isset($data['image_gallery']) ? $data['image_gallery'] : null;

            if($imageGallery){
                $this-> insertImageGallery($product,$imageGallery);
            }

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        return $product;
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
            return config("constant.image.storage_public")."/".config("constant.image.product.storage");
        }
        return config("constant.image.product.storage");
    }


    /**
     * Obtiene la lista de productos que tiene permitido ver el usuario authenticado segun su role
     * de nivel superior
     *
     * @param array $parameters
     * @param array $relationshipNames
     * @param bool $trashed
     * @return collection Product::class
     */
    public function findAllAllowedForAuthUser($parameters=[],$relationshipNames=[],$trashed = false)
    {
        return $this->repository->findAllAllowedForAuthUser($parameters,$relationshipNames,$trashed);
    }


    /**
     * Registra las imagenes en la base de datos y las guarda en el storage
     *
     * @param Product $product
     * @param array $imageGallery
     * @return boolean
     */
    public function insertImageGallery(Product $product,array $imageGallery)
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
            $this->repository->insertImages($product,$dataInsertImages);

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        return false;
    }

}

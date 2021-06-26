<?php


namespace App\Services;


use App\Category;
use App\Helpers\UrlHelper;
use App\Repositories\CategoryRepositoryImpl;
use App\Utils\Services\ImageServiceImpl as ImageUtilServiceImpl;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class CategoryServiceImpl extends GenericServiceImpl implements ICategoryService
{

    private $imageUtilService;

    public function __construct()
    {
        $this-> repository = new CategoryRepositoryImpl();
        $this-> imageUtilService = new ImageUtilServiceImpl();
    }

    /**
     * This is an overriden method from GenericServiceImpl class.
     * Guarda el registro en la base de datos
     *
     * @param array $data
     * @return Category::class
     */
    public function create($data)
    {
        \DB::beginTransaction();
        $category = null;
        try {

            $pictureObject = null;

            if(isset($data['picture_object'])){
                $pictureObject = $data['picture_object'];
                // se genera el nombre de la imagen y guarda en lo parametros
                $data['picture'] = $this-> imageUtilService-> generateName($pictureObject->getClientOriginalName());
            }

            $dataUniqueSlug = ['category_type_id'=>$data['category_type_id']];
            $data['slug'] = UrlHelper::generateUniqueSlug( new Category(),$data['name'],$dataUniqueSlug);

            $parentCategory = null;

            if(isset($data['parent_id'])){
                $parentCategory = $this->repository->find($data['parent_id']);
                $data['level'] = ++$parentCategory-> level;
                $data['code'] = $parentCategory-> code;
            }


//            $data['level'] = $this->getLevel(isset($data['parent_id'])  ? $data['parent_id']  : '');

            //guarda el negocio
            $category = $this-> repository-> create($data);

            if($pictureObject){
                //guarda la imagen en el storage
                $this-> imageUtilService-> saveInterventionImg($pictureObject,$category-> picture,$this->getStorageName(true),70);

            }

            // si no tiene padre pone el id como codigo
            if(!$parentCategory){
                $category = $this-> repository-> update([
                    'id'=>$category->id,
                    'code'=>$category->id
                ]);
            }


            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        return $category;
    }


    /**
     * This is an overriden method from GenericServiceImpl class.
     * Actualiza un registro
     *
     * @param array $data Arreglo con los datos a actualizar
     * @return Category:class
     * @throws \Exception
     */
    public function update($data)
    {
        \DB::beginTransaction();
        $category = null;
        try {

            $pictureObject = null;
            $oldPictureName = "";

            //Cuando envia una imagen
            if(isset($data['picture_object'])){
                //obtiene el nombre de la imagen anterior para ser borrado
                $oldPictureName = $this-> repository->find($data['id'])-> picture;

                $pictureObject = $data['picture_object'];
                //Genera el nombre de la nueva imagen a insertar
                $data['picture'] = $this-> imageUtilService-> generateName($pictureObject->getClientOriginalName());
            }


            if(isset($data['parent_id'])){
                $parentCategory = $this->repository->find($data['parent_id']);
                $data['level'] = ++$parentCategory-> level;
                $data['code'] = $parentCategory-> code;
            }else{
                $data['level'] = 1;
                $data['code'] = $data['id'];
            }

            //guarda el negocio
            $category = $this-> repository-> update($data);


            // Elimina y guarda la nueva imagen en el storage
            if($pictureObject){

                //guarda la imagen en el storage
                $this-> imageUtilService-> saveInterventionImg($pictureObject,$category-> picture,$this->getStorageName(true),70);

                //Borra la imagen anterior del storage
                $this-> imageUtilService-> removeStorage($oldPictureName,$this->getStorageName(true));

            }

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        return $category;
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
            return config("constant.image.storage_public")."/".config("constant.image.category.storage");
        }
        return config("constant.image.category.storage");
    }


    /**
     * Obtiene todas las categorias que pueden tener hijos
     *
     * @param array $parameters
     * @param array $relationshipNames
     * @param bool $trashed
     * @return Collection Category
     */
    public function findAllCanHaveChildren($parameters=[],$relationshipNames=[],$trashed = false)
    {
        array_push($parameters,['parent_id',NULL]);
        array_push($parameters,['level',1]);

        return $this->repository->findAllWhere($parameters,$relationshipNames,$trashed);
    }


    /**
     * Obtiene el nivel de la categoria
     *
     * @param integer $parentCategoryId
     * @return integer
     */
    public function getLevel($parentCategoryId)
    {
//        Log::debug('parentCategoryId: '.$parentCategoryId);
        if(empty($parentCategoryId) ){
            return  1;
        }
        $parentCategory = $this->repository->find($parentCategoryId);
        return ++$parentCategory->level;
    }

}

<?php


namespace App\Services;


use App\Repositories\ImageRepositoryImpl;
use App\Utils\Services\ImageServiceImpl as ImageServiceUtilImpl;


class ImageServiceImpl extends GenericServiceImpl implements IImageService
{

    private $imageServiceUtil;


    public function __construct()
    {
        $this-> repository = new ImageRepositoryImpl();
        $this-> imageServiceUtil = new ImageServiceUtilImpl();

    }


    /**
     * This is an overriden method from GenericServiceImpl class.
     * Borra un registro
     *
     * @param  Image $image
     * @return boolean
     */
    public function delete($image)
    {
        \DB::beginTransaction();
        $result = false;

        try {
            //borra la imagen de la tabla
             $this-> repository-> delete($image);

             $this-> imageServiceUtil-> removeStorage($image-> name,config("constant.image.storage_public")."/".$image->getImageStorage());

            \DB::commit();

        }catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }

        return true;
    }

}

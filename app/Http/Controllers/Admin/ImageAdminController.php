<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Utils\Services\ImageServiceImpl;
use Illuminate\Http\Request;

class ImageAdminController extends Controller
{
    private $imageService;


    public function __construct()
    {
        $this-> imageService = new ImageServiceImpl();
    }



    /**
     * Muestra la imagen que se encuentra en el storage.
     *
     * @param string $path
     * @param string $fileName
     * @return \App\Utils\Services\Illuminate\Http\Response
     */
    public function showImageStorage($path,$fileName){  
        $path = ImageHelper::regenerateReplacePath($path); 
        return  $this-> imageService-> getImage($path,$fileName);
    }


    /**
     * Muestra la imagen que se encuentra en el storage cambiandole el ancho y alto sin importar el aspect Ratio.
     *
     * @param string $path
     * @param integer $width
     * @param integer $height
     * @param string $fileName
     * @return \Illuminate\Http\Response
     */
    public function showImageFit($path,$width,$height,$fileName){  
        $path = ImageHelper::regenerateReplacePath($path); 
        return  $this-> imageService-> getImageFit($path,$fileName,$width,$height);
    }

    /**
     * Muestra la imagen que se encuentra en el storage cambiandole el ancho y alto sin cambiar el aspect Ratio.
     *
     * @param string $path
     * @param integer $width
     * @param integer $height
     * @param string $fileName
     * @return \Illuminate\Http\Response
     */
    public function showImageResize($path,$width,$height,$fileName){  
        $path = ImageHelper::regenerateReplacePath($path); 
        return  $this-> imageService-> getImageResize($path,$fileName,$width,$height);
    }


    /**
     * Muestra la imagen que se encuentra en el storage cambiandole el ancho y alto sin importar el aspect Ratio.
     *
     * @param string $path
     * @param integer $width
     * @param integer $height
     * @param string $fileName
     * @return \Illuminate\Http\Response
     */
    public function showImageFitCache($path,$width,$height,$fileName){  
        $path = ImageHelper::regenerateReplacePath($path); 
        return  $this-> imageService-> getImageFitCache($path,$fileName,$width,$height);
    }

    /**
     * Muestra la imagen que se encuentra en el storage cambiandole el ancho y alto sin cambiar el aspect Ratio.
     *
     * @param string $path
     * @param integer $width
     * @param integer $height
     * @param string $fileName
     * @return \Illuminate\Http\Response
     */
    public function showImageResizeCache($path,$width,$height,$fileName){  
        $path = ImageHelper::regenerateReplacePath($path); 
        return  $this-> imageService-> getImageResizeCache($path,$fileName,$width,$height,true);
    }


}

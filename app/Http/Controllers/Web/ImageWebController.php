<?php

namespace App\Http\Controllers\Web;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Utils\Services\ImageServiceImpl;
use Illuminate\Http\Request;

class ImageWebController extends Controller
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
    	return  $this-> imageService-> getImage("public/".$path,$fileName);
    }

    /**
     * Muestra la imagen que se encuentra en el storage cambiandole el ancho y alto sin importar el aspect Ratio.
     *
     * @param string $path
     * @param integer $width
     * @param integer $height
     * @param string $fileName
     * @return \App\Utils\Services\Illuminate\Http\Response
     */
    public function showImageFit($path,$width,$height,$fileName){
        $path = ImageHelper::regenerateReplacePath($path);
    	return  $this-> imageService-> getImageFit("public/".$path,$fileName,$width,$height);
    }

    /**
     * Muestra la imagen que se encuentra en el storage cambiandole el ancho y alto sin cambiar el aspect Ratio.
     *
     * @param string $path
     * @param integer $width
     * @param integer $height
     * @param string $fileName
     * @return \App\Utils\Services\Illuminate\Http\Response
     */
    public function showImageResize($path,$width,$height,$fileName){
        $path = ImageHelper::regenerateReplacePath($path);
    	return  $this-> imageService-> getImageResize("public/".$path,$fileName,$width,$height);
    }
}

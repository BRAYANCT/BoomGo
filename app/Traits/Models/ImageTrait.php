<?php

namespace App\Traits\Models;

use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


trait ImageTrait
{


    /**
     * Trae el storage de la imagen de perfil
     *
     * @param bool $public
     * @return string
     */
    public function getImageStorage()
    {        
        return config("constant.image.general.storage");
    }


    /**
     * Trae el url de la imagen con un ancho y alto por defecto
     * @param string $columnName
     * @param Boolean $acpectRatio
     * @param Boolean $public
     * @return string
    */
    public function getUrlThumbnail($columnName,$acpectRatio=true,$public=false)
    {
        $width = config("constant.image.general.thumbnail_width");
        $height = config("constant.image.general.thumbnail_height");

        return $this->getUrlImageResize($columnName,$width,$height,$acpectRatio,$public);
    }


    /**
     * Trae el url de la imagen con un ancho y alto por defecto
     * @param string $columnName
     * @param Boolean $acpectRatio
     * @param Boolean $public
     * @return string
    */
    public function getUrlImageMedium($columnName,$acpectRatio=true,$public=false)
    {
        $width = config("constant.image.general.medium_width");
        $height = config("constant.image.general.medium_height");

        return $this->getUrlImageResize($columnName,$width,$height,$acpectRatio,$public);
    }


    /**
     * Trae el url de la imagen con un ancho y alto por defecto
     * @param string $columnName
     * @param Boolean $acpectRatio
     * @param Boolean $public
     * @return string
    */
    public function getUrlImageLarge($columnName,$acpectRatio=true,$public=false)
    {
        $width = config("constant.image.general.large_width");
        $height = config("constant.image.general.large_height");

        return $this->getUrlImageResize($columnName,$width,$height,$acpectRatio,$public);
    }



    /**
     * Obtiene el url de una imagen
     *
     * @param string $columnName
     * @param Boolean $public
     * @return string
    */
    public function getUrlImage($columnName,$public=false)
    {
        if(isset($this-> attributes[$columnName])){
            return ImageHelper::getUrlImage($this-> getImageStorage(),$this-> attributes[$columnName],$public);
        }
         return '';
    }


    /**
     * Trae el url de la imagen con un ancho y alto segun los parametros enviados sin cambiar la proporciaones originales
     *
     * @param string $columnName
     * @param integer $width
     * @param integer $height
     * @param Boolean $acpectRatio
     * @param Boolean $public
     * @return string
    */
    public function getUrlImageResize($columnName,$width,$height,$acpectRatio=true,$public=false)
    {
        if(isset($this-> attributes[$columnName])){
            if($acpectRatio){
                return ImageHelper::getUrlImageResize($this->getImageStorage(),$this-> attributes[$columnName],$width,$height,$public);
            }

            return ImageHelper::getUrlImageFit($this->getImageStorage(),$this-> attributes[$columnName],$width,$height,$public);
        }
        return '';
    }

}

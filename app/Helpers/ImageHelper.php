<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class ImageHelper {
    
    
    /**
     * Trae el url de la imagen con un ancho y alto variable segun los parametros
     *
     * @param  string $path Ruta del storage
     * @param  string $imageName Nombre de la imagen
     * @param integer $width Nuevo ancho de la imagen
     * @param integer $height Nuevo alto de la imagen
     * @param Boolean $public
     * @return string
    */
    public static function getUrlImageFit($path,$imageName,$width,$height,$public=false){        
        if(empty($imageName)){
            return '';
        }

        $path = static::replacePathSlash($path);

        $route = 'admin.images_fit.show';
        if($public){
            $route = 'images_fit.show';
        }

        //obtiene el url de la imagen
        return route($route,['path'=>$path,'imageName'=> $imageName,'width'=>$width,'height'=>$height]);
    }


    /**
     * Trae el url de la imagen con un ancho y alto variable segun los parametros manteniendo las dimensiones de la imagen
     *
     * @param  string $path Ruta del storage
     * @param  string $imageName Nombre de la imagen
     * @param integer $width Nuevo ancho de la imagen
     * @param integer $height Nuevo alto de la imagen
     * @param Boolean $public
     * @return string
    */
    public static function getUrlImageResize($path,$imageName,$width,$height,$public=false){        
        if(empty($imageName)){
            return '';
        }

        $path = static::replacePathSlash($path);

        $route = 'admin.images_resize.show';
        if($public){
            $route = 'images_resize.show';
        }

        //obtiene el url de la imagen
        return route($route,['path'=>$path,'imageName'=> $imageName,'width'=>$width,'height'=>$height]);
    }


    /**
     * Trae el url de la imagen 
     *
     * @param  string $path Ruta del storage
     * @param  string $imageName Nombre de la imagen
     * @param Boolean $public
     * @return string
    */
    public static function getUrlImage($path,$imageName,$public=false){        

        if(empty($imageName)){
            return '';
        }

        $path = static::replacePathSlash($path);

        $route = 'admin.images.storage.show';
        if($public){
            $route = 'images.storage.show';
        }

        //obtiene el url de la imagen
        return route($route,['path'=>$path,'imageName'=> $imageName]);
    }



    /**
     * Reemplaza la barra diagonal si el path esta compuesto por mas subdirectorios para que lo reconosca como parametro en as url
     * 
     * @param  string $path Ruta del storage
     * @return string
    */
    public static function replacePathSlash($path){

        if($path=="/"){
            return "root";
        }

        //obtiene el url de la imagen
        return preg_replace('/\//', '_', $path);
    }
 

    /**
     * Regenera la ruta en donde la barra diagonal fue reemplazada
     *
     * @param  string $path Ruta del storage
     * @return string
    */
    public static function regenerateReplacePath($path){
        if($path=="root"){
            return "";
        }
        //obtiene el url de la imagen
        return preg_replace('/_/', '/', $path);
    }

    
}
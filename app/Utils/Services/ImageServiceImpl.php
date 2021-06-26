<?php 
namespace App\Utils\Services; 

use App\Utils\Services\IImageService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;



class ImageServiceImpl implements IImageService{
    

    public function __construct(){

    }

    /**
     * Obtiene la imagen del storage y devuelve el response
     *
     * @param String $path [Ruta del storage]
     * @param String $imageName [Nombre de la imagen]
     * @return Illuminate\Http\Response
     */   
    public function getImage($path,$imageName){

        $imageWithpath = $path."/".$imageName;
        //existe o 404
        $this-> existOrFail($imageWithpath);

        return \Storage::response($imageWithpath);
    }


    /**
     * Obtiene la imagen del storage cambia el tamaño devuelve el response
     *
     * @param String $path [Ruta del storage]
     * @param String $imageName [Nombre de la imagen]
     * @param Integer $width [Nuevo ancho de la imagen]
     * @param Integer $height [Nuevo alto de la imagen]
     * @param Boolean $acpectRatio 
     * @return Illuminate\Http\Response
     */  
    public function getImageResize($path,$imageName,$width,$height,$acpectRatio=true){

        $imageWithpath = $path."/".$imageName;

        //existe o 404
        $this-> existOrFail($imageWithpath);

        $imageContents = \Storage::get($imageWithpath);

        $imageIntervention = Image::make($imageContents);

        $imageIntervention = $this->resizeIntervention($imageIntervention, $width, $height, $acpectRatio);

        return  $imageIntervention->response();
    }

    /**
     * Obtiene la imagen del storage cambia el tamaño sin importar las dimensiones originales y devuelve el response
     *
     * @param  string $path Ruta del storage
     * @param  string $imageName Nombre de la imagen
     * @param integer $width Nuevo ancho de la imagen
     * @param integer $height Nuevo alto de la imagen
     * @return Illuminate\Http\Response
     */
    public function getImageFit($path,$imageName,$width,$height){

        $imageWithpath = $path."/".$imageName;

        //existe o 404
        $this-> existOrFail($imageWithpath);

        $imageContents = \Storage::get($imageWithpath);

        $image = Image::make($imageContents)
                    ->fit($width, $height,function ($constraint){                
                        $constraint->upsize();
                    },'top');

        return  $image->response();
    }



    /**
     * Obtiene la imagen del storage cambia el tamaño sin cambiar las dimensiones originales y devuelve el response
     *
     * @param String $path [Ruta del storage]
     * @param String $imageName [Nombre de la imagen]
     * @param Integer $width [Nuevo ancho de la imagen]
     * @param Integer $height [Nuevo alto de la imagen]
     * @param Boolean $acpectRatio 
     * @return Illuminate\Http\Response
     */
    public function getImageResizeCache($path,$imageName,$width,$height,$acpectRatio=true){

        $imageWithpath = $path."/".$imageName;

        //existe o 404
        $this-> existOrFail($imageWithpath);

        $imageContents = \Storage::get($imageWithpath);

        $image = Image::cache(function($image)use($width, $height, $imageContents,$acpectRatio ) {

                $image ->make($imageContents)
                        ->resize($width, $height,function ($constraint) use($acpectRatio) {
                            if($acpectRatio){
                                $constraint->aspectRatio();
                            }else{
                                $constraint->upsize();
                            }
                        });                                

        }, config('imagecache.lifetime'), true);

        return  $image->response();
    }

    /**
     * Obtiene la imagen del storage cambia el tamaño sin importar las dimensiones originales y devuelve el response
     *
     * @param String $path Ruta del storage
     * @param String $imageName Nombre de la imagen
     * @param Integer $width Nuevo ancho de la imagen
     * @param Integer $height Nuevo alto de la imagen
     * @return Illuminate\Http\Response
     */
    public function getImageFitCache($path,$imageName,$width,$height){

        $imageWithpath = $path."/".$imageName;

        //existe o 404
        $this-> existOrFail($imageWithpath);

        $imageContents = \Storage::get($imageWithpath);

        $image = Image::cache(function($image)use($width, $height, $imageContents) {
            $image  ->make($imageContents)
                    ->fit($width, $height,function ($constraint){                
                        $constraint->upsize();
                    },'top');

        }, config('imagecache.lifetime'), true);

        return  $image->response();
    }

    
    /**
     * Guarda una imagen en una carpeta dentro del storage
     *
     * @param  Illuminate\Http\UploadedFile $imagen
     * @param String $storageName [Nombre del storage]
     * @return String
     */
    public function storeImg($imagen,$storageName){
        $imgWithPath = $imagen->store($storageName);
        
        if($imgWithPath){
            $pathInfo = pathinfo($imgWithPath);
            return $pathInfo['basename'];
        }
        return "";
    }



    /**
     * Guarda una imagen en una carpeta dentro del storage
     *
     * @param [Illuminate\Http\UploadedFile] $imagen [El objecto imagen subido del formulario]
     * @param String $imageName [Nombre de la imagen para guardar en el sistema]
     * @param String $storageName [Nombre del storage donde se va guardar]
     * @param Integer $calidad [Calidad de la imagen de 0 a 100]
     * @param Integer $width [Ancho de la imagen]
     * @param Integer $height [Alto de la imagen]
     * @param Boolean $acpectRatio [Si mantiene las dimensiones originales o no]
     * @return String
     */
    public function saveInterventionImg($imagen,$imageName='',$storageName,$calidad=100,$width=null,$height=null,$acpectRatio=true){
        
        // Log::debug('saveInterventionImg');

        //imagen intervention
        $imageIntervention = Image::make($imagen);

        // si envia los parameteros ingresa
        if($width || $height){
            $imageIntervention = $this->resizeIntervention($imageIntervention,$width, $height,$acpectRatio);
            
        // si no envia parametros de alto y ancho valida con el maximo
        }else{

            $maxWidth = config('constant.image.max_width');
            $maxHeight = config('constant.image.max_height');

            // si las dimensiones de la imagen son mayores a la maxima reduce la imagen    
            if($imageIntervention->width() > $maxWidth ||  $imageIntervention ->height() > $maxHeight){
                 
               $imageIntervention = $this->resizeIntervention($imageIntervention,$maxWidth, $maxHeight,$acpectRatio);

            }
        }
        // si no envia nombre de imagen se genera
        if(empty($imageName)){
             $imageName = $this->generateName();
        }
       
        Storage::put($storageName."/".$imageName, (string) $imageIntervention->encode(null, $calidad));
        return $imageName;
    }


    /**
     * Redimensiona 1 imagen
     *
     * @access public
     * @param Intervention\Image\Facades\Image $image
     * @param integer $width
     * @param integer $height
     * @param boolean $acpectRatio
     * @return Intervention\Image\Facades\Image
     */
    public function resizeIntervention($image,$width, $height,$acpectRatio=true){
        return $image->resize($width, $height, function ($constraint) use($acpectRatio) {
                    if($acpectRatio){
                        $constraint->aspectRatio();
                    }else{
                        $constraint->upsize();
                    }                            
                });
    }

    /**
     * Guarda una imagen con las iniciales del texto enviado
     *
     * @access public
     * @param String $texto 
     * @param String $path
     * @param String $imageName
     * @return boolean
     */
    public function saveAvatarImage($texto,$path,$imageName=''){
         // si no envia nombre de imagen se genera
        if(empty($imageName)){
             $imageName = $this->generateName();
        }

        $imagen = \Avatar::create($texto)->getImageObject();

        $this-> saveInterventionImg($imagen,$imageName,$path);

        return $imageName;
    }


     /**
     * Borra 1 imagen de una carpeta del storage
     *
     * @access public
     * @param String $imgName 
     * @param String $storageName 
     * @return boolean
     */
    function removeStorage($imgName,$storagePath){
        return Storage::delete($storagePath."/".$imgName);
    }


    /**
     * Borra varias imagenes de una carpeta del  storage
     *
     * @access public
     * @param Array $imgNameArray 
     * @param String $storageName 
     * @return boolean
     */
    function removeStorageArray($imgNameArray,$storagePath){
        $imagenes = array();

        foreach ($imgNameArray as $key => $imgName) {
            array_push($imagenes, $storagePath."/".$imgName);
        }

        return Storage::delete($imagenes);
    }


    /**
     * Crea el nombre de una imagen único
     *
     * @access public
     * @param String $imgName     
     * @return string
     */
    function generateName($imgName = ""){
        if($imgName == ""){
            return rand()."-".time().".jpeg";
        }
        $partes_ruta = pathinfo($imgName);
        $extension = $partes_ruta['extension'];
        return rand()."-".time().".".$extension;
    }

    /**
     * Verifica si la imagen existe, si no existe envia a la pagina 404
     *
     * @access public
     * @param String $imageWithpath   
     * @return abort
     */
    function existOrFail($imageWithpath){
        $exists = \Storage::exists($imageWithpath);
        if(!$exists){
            abort(404);
        }
    }


    /**
     * Obtiene todas los url de las imagenes de una cadena de texto
     *
     * @access public
     * @param String $text     
     * @return array
     */
    function getUrlImagesOfText($text){
        preg_match_all('!(https?:)?//\S+\.(?:jpe?g|jpg|png|gif)!Ui', $text, $matches);
        return $matches[0];
    }

    /**
     * Obtiene todas los nombres de las imagenes de una cadena de texto
     *
     * @access public
     * @param String $text    
     * @return array
     */
    function getNamesImagesOfText($text){
        $imagesUrl = $this-> getUrlImagesOfText($text);
        
        $imagesName = array();

        foreach ($imagesUrl as $key => $value) {
            array_push($imagesName, $this->baseUrlFileName($value));
        }
        return $imagesName;
    }

    /**
     * Obtiene el nombre de la imagen de un url
     *
     * @access public
     * @param String $url  
     * @return String
     */
    function baseUrlFileName($url){
        $fileName = explode("/", parse_url($url, PHP_URL_PATH));
        return array_pop($fileName);       
    }




}
?>
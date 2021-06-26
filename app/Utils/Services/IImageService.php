<?php 
namespace App\Utils\Services; 


interface IImageService{
    

    /**
     * Obtiene la imagen del storage y devuelve el response
     *
     * @param String $path [Ruta del storage]
     * @param String $imageName [Nombre de la imagen]
     * @return Illuminate\Http\Response
     */  
    public function getImage($path,$imageName);


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
    public function getImageResize($path,$imageName,$width,$height,$acpectRatio=true);


    /**
     * Obtiene la imagen del storage cambia el tamaño sin importar las dimensiones originales y devuelve el response
     *
     * @param String $path Ruta del storage
     * @param String $imageName Nombre de la imagen
     * @param Integer $width Nuevo ancho de la imagen
     * @param Integer $height Nuevo alto de la imagen
     * @return Illuminate\Http\Response
     */
    public function getImageFit($path,$imageName,$width,$height);

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
    public function getImageResizeCache($path,$imageName,$width,$height,$acpectRatio=true);

    /**
     * Obtiene la imagen del storage cambia el tamaño sin importar las dimensiones originales y devuelve el response
     *
     * @param String $path Ruta del storage
     * @param String $imageName Nombre de la imagen
     * @param Integer $width Nuevo ancho de la imagen
     * @param Integer $height Nuevo alto de la imagen
     * @return Illuminate\Http\Response
     */
    public function getImageFitCache($path,$imageName,$width,$height);

    /**
     * Guarda una imagen en una carpeta dentro del storage
     *
     * @param  Illuminate\Http\UploadedFile $imagen
     * @param String $storageName [Nombre del storage]
     * @return String
     */
    public function storeImg($imagen,$storageName);


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
    public function saveInterventionImg($imagen,$imageName='',$storageName,$calidad=100,$width=null,$height=null,$acpectRatio=true);


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
    public function resizeIntervention($image,$width, $height,$acpectRatio=true);


    /**
     * Guarda una imagen con las iniciales del texto enviado
     *
     * @access public
     * @param String $texto 
     * @param String $path
     * @param String $imageName
     * @return boolean
     */
    public function saveAvatarImage($texto,$path,$imageName='');


    /**
     * Borra 1 imagen de una carpeta del storage
     *
     * @access public
     * @param String $imgName 
     * @param String $storageName 
     * @return boolean
     */
    public function removeStorage($imgName,$storageName);

    /**
     * Borra varias imagenes de una carpeta del  storage
     *
     * @access public
     * @param Array $imgNameArray 
     * @param String $storageName 
     * @return boolean
     */
    public function removeStorageArray($imgNameArray,$storageName);


    /**
     * Crea el nombre de una imagen único
     *
     * @access public
     * @param String $imgName     
     * @return string
     */
    public function generateName($imgName = "");

    /**
     * Verifica si la imagen existe, si no existe envia a la pagina 404
     *
     * @access public
     * @param String $imageWithpath   
     * @return abort
     */
    public function existOrFail($imageWithpath);


    /**
     * Obtiene todas los url de las imagenes de una cadena de texto
     *
     * @access public
     * @param String $text     
     * @return array
     */
    public function getUrlImagesOfText($text);

    /**
     * Obtiene todas los nombres de las imagenes de una cadena de texto
     *
     * @access public
     * @param String $text    
     * @return array
     */
    public function getNamesImagesOfText($text);

    /**
     * Obtiene el nombre de la imagen de un url
     *
     * @access public
     * @param String $url  
     * @return String
     */
    public function baseUrlFileName($url);

}
?>
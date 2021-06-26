<?php  
namespace App\Helpers;

use App\Constants\ModalMessageConstant;
use App\Utils\ModalMessage;
use Illuminate\Support\Facades\Log;

/**
* Esta clase se encarga de los mensajes modales
*
*/
class ModalMessageHelper{
	

	/**
     * Obtiene el mensaje success
     * @param array $texto Mensajes a mostrar en la modal
     * @param string $titulo titulo de la modal
     * @param string $textoBoton Texto del botón
     * @return Util\ModalMessage::class
    */
	public static function success(array $texto,string $titulo="",string  $textoBoton="") {		
		$tipo = ModalMessageConstant::TYPE_SUCCESS;
		return new ModalMessage($texto,$tipo,$titulo,$textoBoton);
	}


	/**
     * Obtiene el mensaje error
     * @param array $texto Mensajes a mostrar en la modal
     * @param string $titulo titulo de la modal
     * @param string $textoBoton Texto del botón
     * @return Util\ModalMessage::class
    */
	public static function error(array $texto,string $titulo="",string  $textoBoton="") {		
		$tipo = ModalMessageConstant::TYPE_ERROR;
		return new ModalMessage($texto,$tipo,$titulo,$textoBoton);
	}

	/**
     * Obtiene el mensaje danger
     * @param array $texto Mensajes a mostrar en la modal
     * @param string $titulo titulo de la modal
     * @param string $textoBoton Texto del botón
     * @return Util\ModalMessage::class
    */
	public static function danger(array $texto,string $titulo="",string  $textoBoton="") {		
		return static::error($texto,$titulo,$textoBoton) ;
	}

	/**
     * Obtiene el mensaje info
     * @param array $texto Mensajes a mostrar en la modal
     * @param string $titulo titulo de la modal
     * @param string $textoBoton Texto del botón
     * @return Util\ModalMessage::class
    */
	public static function info(array $texto,string $titulo="",string  $textoBoton="") {		
		$tipo = ModalMessageConstant::TYPE_INFO;
		return new ModalMessage($texto,$tipo,$titulo,$textoBoton);
	}

		/**
     * Obtiene el mensaje warning
     * @param array $texto Mensajes a mostrar en la modal
     * @param string $titulo titulo de la modal
     * @param string $textoBoton Texto del botón
     * @return Util\ModalMessage::class
    */
	public static function warning(array $texto,string $titulo="",string  $textoBoton="") {		
		$tipo = ModalMessageConstant::TYPE_WARNING;
		return new ModalMessage($texto,$tipo,$titulo,$textoBoton);
	}

}
?>
<?php  
namespace App\Utils;

use App\Constants\ModalMessageConstant;


/**
* Esta clase se tiene las variables que necesita la modal
*
*/
class ModalMessage{
	

	public $titulo;
	
	public $texto;
	
	public $tipo;
	
	public $textoBoton;


	/**
     * Inicializa el objecto
     *
     * @param  array $texto mensajes a mostrar en la modal
     * @param  string $tipo tipo de modal
     * @param string $titulo titulo de la modal
     * @param string $textoBoton Texto del botón
    */
	public function __construct(array $texto, string $tipo = "", string $titulo="", string  $textoBoton="") {
	
		$this-> tipo = empty($tipo) ? ModalMessageConstant::TYPE_INFO : $tipo;

		$this-> titulo = empty($titulo) ? $this->getTituloPorTipo($this-> tipo) : $titulo;
		
		$this-> texto = $texto;

		$this-> textoBoton = empty($textoBoton) ? 'Aceptar' : $textoBoton;

	}



	/**
     * Obtiene el titulo por defecto segun el tipo de mensaje modal
     *
     * @param  string $tipo Tipo de modal
     * @return string
    */
	public function getTituloPorTipo($tipo):string {
		$titulo = "";
		if($tipo == ModalMessageConstant::TYPE_SUCCESS) {
			$titulo = "Éxito";
		}else if($tipo == ModalMessageConstant::TYPE_DANGER || $tipo == ModalMessageConstant::TYPE_ERROR) {
			$titulo = "Error";
		}else if($tipo == ModalMessageConstant::TYPE_INFO) {
			$titulo = "Mensaje";
		}else if($tipo == ModalMessageConstant::TYPE_WARNING) {
			$titulo = "Advertencia";
		}
		return  $titulo;
	}

	
}
?>
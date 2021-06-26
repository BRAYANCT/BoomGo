<?php
namespace App\Helpers;

class ValidateFormHelper {
 
	
    /**
    * Convierte los errores en una cadena de texto html con la etiqueta ul,li
    * @param array
    * 
    * @return string
    */
    public static function getMessagesListHtml($errors){
        
        $mensajeHtml = "<ul>";
        foreach ($errors as $key => $error) {
            foreach($error as $mensaje){
                    $mensajeHtml .= "<li>".$mensaje."</li>";
            }
        }
        $mensajeHtml .= "</ul>";

        return $mensajeHtml;
    }


	/**
	* Obtiene la class de bootrap para los errores
    * @param int $user_id User-id
    * 
    * @return string
    */
    public static function getValidClass($errors,$nameInput){
    	
    	if($errors -> any()){
    		if($errors -> has($nameInput)){
    			return 'is-invalid';
    		}else{
    			return 'is-valid';
    		}								
    	}
	   	return '';
    }

    /**
	* Obtiene la class de bootrap para los errores
    * @param int $user_id User-id
    * 
    * @return string
    */
    public static function getErrorDiv($errors,$nameInput){
    	
		if ($errors -> any()){
			if($errors -> has($nameInput)){
				return "<div class='invalid-feedback'>
							{$errors -> first($nameInput)}
						</div>";
			}else{
				return "<div class='valid-feedback'>
							Campo correcto
						</div>";
			}       										
		}

	   	return '';
    }


    /**
    * Obtiene la class de bootrap para los errores
    * @param int $user_id User-id
    * 
    * @return string
    */
    public static function getBasicErrorDiv($errors,$nameInput){
        
        if ($errors -> any()){
            if($errors -> has($nameInput)){
                return "<small class='form-text text-muted text-danger'>
                            {$errors -> first($nameInput)}
                        </small>";
            }else{
                return "<small class='form-text text-muted text-success'>
                            Campo correcto
                        </small>";;
            }                                               
        }
        return '';
    }


	
}
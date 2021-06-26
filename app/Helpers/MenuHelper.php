<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class MenuHelper {
 

   /**
    * Compara  el url actual con el url del parametro y devuelve una cadena de texto  
    * @param string,string
    * @return string
    */
    public static function isCurrentUrl($url,$class="active"){ 
        if(\Request::url() == $url){
          return $class;
        }
    }


    /**
    * Compara  el url actual con los url del parametro y devuelve una cadena de texto 
    * @param array,string
    * @return string
    */
    public static function isCurrentArrayUrl($urlArray,$class="active"){ 
        $current_url = \Request::url();
        if(in_array($current_url, $urlArray)) {
          return $class;
        }
    }

    /**
    * Compara  el patter que envía con el url de la peticion actual  
    * @param string,string
    * @return string
    */
    public static function isPatternUrl($pattern,$class="active"){ 
        if(\Request::is($pattern)){
          return $class;
        }
    }


    /**
    * Compara  el patter que envía con el url de la peticion actual  
    * @param string,string
    * @return string
    */
    public static function isPatternArrayUrl($patternArray,$class="active"){ 
        $retorno =  "";
        foreach ($patternArray as $key => $pattern) {
          if(\Request::is($pattern)){
            $retorno = $class;
            break;
          }
        }        
        return $retorno;
    }


}
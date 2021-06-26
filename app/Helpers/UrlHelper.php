<?php
namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;

class UrlHelper {

    /**
     * genera el slug a partir de un texto
     * @param string
     *
     * @return string
     */
    public static function generateSlug($texto){

        $texto = trim(mb_strtolower($texto));
        //algunas palabras pueden estar separadas por - o doble - por eso lo reemplazo por espacio para luego ponerle el -
        $texto = preg_replace('/\-/', ' ', $texto);
        $texto = preg_replace('/\s+/', ' ',$texto);


        //quita lo caractes especiales y simbolos
        $arraySimbolos = array('/\°/','/\#/','/\$/','/\%/','/\&/','/\//','/\|/','/\[/','/\]/',"/\'/",'/\"/','/\{/','/\}/','/\,/','/\./','/\:/','/\;/','/\¿/','/\?/','/\=/','/\*/','/\^/','/\¡/','/\!/','/\~/','/\`/','/\´/','/\+/','/\(/','/\)/','/\_/','/\¨/','/\‘/','/\’/','/\</','/\>/','/\“/','/\”/','/\@/'
        );
        $texto = preg_replace($arraySimbolos, '', $texto);

        //reemplaza las letras con tilde
        $texto = preg_replace(array('/\á/','/\é/','/\í/','/\ó/','/\ú/'),array('a','e','i','o','u'), $texto);

        // reemplaza los espacion en blanco por un guion
        $slug = preg_replace("/ /", '-', $texto);

        return $slug;
    }

    /**
     * Genera el slug validando que no exista el campo en la base de datos
     * @param Model $model
     * @param string $text
     * @param array $data
     * @return string
     */
    public static function generateUniqueSlug(Model $model,$text,$data=[]){

        $slug = static::generateSlug($text);

        $row = $model->uniqueSlug($slug,$data)->first();

        // si existe le agrega un numero al slug
        if($row){
            for ($i=1; $i < 100; $i++) {

                $newSlug = $slug."-".$i;

                $row = $model->uniqueSlug($newSlug,$data)->first();
                // si no existe guarda el nuevo slug
                if(!$row){
                    $slug = $newSlug;
                    break;
                }
            }
        }
        return $slug;
    }


    /**
     * Borra parametros de un url
     *
     * @param string $url
     * @param array $keys
     * @return string
     */
    public static function removeUrlParameters(string $url, array $keys)
    {
        $newUrl = "";
        foreach ($keys as $value){
            $newUrl = preg_replace('~(\?|&)'.$value.'=[^&]*~', '$1', $url);
        }
        return $newUrl;
    }

}

?>

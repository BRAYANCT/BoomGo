<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class NumberHelper {


   /**
    * Da el formato decimal a un numero
    * @param numeric $number
    * @return float
    */
    public static function formatDefault($number){
        return number_format($number, 2,'.','');
    }



}

<?php


namespace App\Helpers;


use App\Order;

class OrderStateHelper
{
    /**
     * Trae los id de todos los estados
     *
     * @return array
     */
    public static function getAllId(){
        return array(
            static::getConstantId('OUTSTANDING_ID'),
            static::getConstantId('PAY_OUT_ID'),
            static::getConstantId('DELIVERED_ID'),
            static::getConstantId('FAILED_PAYMENT_ID'),
            static::getConstantId('CANCELLED_ID'),
        );
    }


    /**
     * Trae el id de la constante por el nombre
     *
     * @param String $name
     * @return integer
     */
    public static function getConstantId($name){
        return config('constant.orderstate.'.$name);
    }

//
//    /**
//     * Trae los id de los estados que pueden ser cancelados
//     *
//     * @return array
//     */
//    public static function getAllIdCanCancelled(){
//        return (new Order())->getAllIdCanCancelled();
//    }
}

<?php


namespace App\Helpers;


use App\Services\ProvinceServiceImpl;

class ProvinceHelper
{
    private static $service;

    public function __construct()
    {

    }

    public static function init()
    {
        static::$service = new ProvinceServiceImpl();
    }


    /**
     * Compara  el url actual con el url del parametro y devuelve una cadena de texto
     *
     * @param string,string
     * @return string
     */
    public static function find($id)
    {
        static::init();
        return static::$service->find($id);
    }

    /**
     * Obtiene el nombre del tipo de proveedor
     *
     * @param integer $id
     * @return string
     */
    public static function getName($id)
    {
        $province = self::find($id);
        return $province ? $province->name : '';
    }
}

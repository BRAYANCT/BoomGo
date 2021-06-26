<?php


namespace App\Helpers;


use App\Services\ProviderTypeServiceImpl;

class ProviderTypeHelper
{
    private static $service;

    public function __construct()
    {

    }

    public static function init()
    {
        static::$service = new ProviderTypeServiceImpl();
    }

    /**
     * Compara  el url actual con el url del parametro y devuelve una cadena de texto
     *
     * @param string,string
     * @return string
     */
    public static function find($id){
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
        $providerType = self::find($id);
        return $providerType ? $providerType->name : '';
    }

}

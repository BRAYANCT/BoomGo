<?php


namespace App\Repositories;


use App\Business;

interface IBusinessRepository
{

    /**
     * Pone todos los tipos de proveedores nuevos y borra los antiguos
     *
     * @param Business $business
     * @param array $data
     * @return Boolean
     */
    public function syncProviderTypes(Business $business,$data);

    /**
     * Registra las imagenes
     *
     * @param Business $business
     * @param array $data Arreglo con los datos
     * @return boolean
     */
    public function insertImages(Business $business, array $data);

}

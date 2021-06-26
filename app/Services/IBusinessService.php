<?php


namespace App\Services;


use App\Business;

interface IBusinessService
{
    /**
     * Registra las imagenes en la base de datos y las guarda en el storage
     *
     * @param Business $business
     * @param array $imageGallery
     * @return boolean
     */
    public function insertImageGallery(Business $business,array $imageGallery);
}

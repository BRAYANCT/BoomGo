<?php


namespace App\Services;


use App\Business;

interface IBusinessPaymentMethodService
{
    /**
     * Guarda o actualiza una transferencia bancaria de un negocio.
     * @param Business $business
     * @param array $data
     * @return Business::class
     * @throws \Exception
     */
    public function storeOrUpdateWireTransferByBusiness(Business $business,$data);
}

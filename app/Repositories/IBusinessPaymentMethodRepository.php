<?php


namespace App\Repositories;


use App\BusinessPaymentMethod;

interface IBusinessPaymentMethodRepository
{
    /**
     * Pone todos los número de cuenta nuevos y borra los antiguos
     *
     * @param BusinessPaymentMethod $businessPaymentMethod
     * @param array $data
     * @return Boolean
     */
    public function syncAccountNumbers(BusinessPaymentMethod $businessPaymentMethod,$data);

}

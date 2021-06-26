<?php


namespace App\Repositories;


use App\Business;
use App\BusinessPaymentMethod;
use App\Exceptions\DataBaseGenericException;

class BusinessPaymentMethodRepositoryImpl extends GenericRepositoryImpl implements IBusinessPaymentMethodRepository
{

    public function __construct()
    {
        $this-> model = new BusinessPaymentMethod();
    }

    /**
     * Pone todos los número de cuenta nuevos y borra los antiguos
     *
     * @param BusinessPaymentMethod $businessPaymentMethod
     * @param array $data
     * @return Boolean
     */
    public function syncAccountNumbers(BusinessPaymentMethod $businessPaymentMethod,$data)
    {
        try {

            $nameArray = $data['name'];

            $businessPaymentMethod->accountNumbers()->delete();

            foreach ($nameArray as $index => $name){
                $dataCreate = array(
                    'name' => $data['name'][$index],
                    'name_bank' => $data['name_bank'][$index],
                    'account_number' => $data['account_number'][$index],
                    'cci' => $data['cci'][$index],
                );
                $businessPaymentMethod->accountNumbers()->create($dataCreate);
            }


        }catch (\Exception $e) {
            throw new DataBaseGenericException($e->getMessage());
        }
        return true;
    }
}

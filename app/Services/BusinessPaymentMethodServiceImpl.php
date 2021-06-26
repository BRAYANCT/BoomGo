<?php


namespace App\Services;


use App\Business;
use App\Repositories\BusinessPaymentMethodRepositoryImpl;

class BusinessPaymentMethodServiceImpl extends GenericServiceImpl implements IBusinessPaymentMethodService
{

    public function __construct()
    {
        $this-> repository = new BusinessPaymentMethodRepositoryImpl();
    }


    /**
     * Guarda o actualiza una transferencia bancaria de un negocio.
     * @param Business $business
     * @param array $data
     * @return Business::class
     * @throws \Exception
     */
    public function storeOrUpdateWireTransferByBusiness(Business $business,$data)
    {
        \DB::beginTransaction();
        $businessPaymentMethod = null;
        try {
            $parameters = array(
                ['payment_method_id','=',config('constant.paymentmethod.wire_transfer.id')],
                ['business_id','=',$business->id]
            );
            $businessPaymentMethod = $this->repository->findWhere($parameters);

            if($businessPaymentMethod){
                $dataUpdate = array(
                    'id'=> $businessPaymentMethod->id,
                    'instructions' => $data['instructions']
                );
                $businessPaymentMethod = $this->repository->update($dataUpdate);

            }else{
                $dataCreate = array(
                    'payment_method_id' => config('constant.paymentmethod.wire_transfer.id'),
                    'business_id' => $business->id,
                    'instructions' => $data['instructions']
                );
                $businessPaymentMethod = $this->repository->create($dataCreate);
            }

            $this->repository->syncAccountNumbers($businessPaymentMethod,$data);

            \DB::commit();

        } catch (\Exception $e) {

            \DB::rollBack();
            throw $e;
        }

        return $businessPaymentMethod;
    }

}

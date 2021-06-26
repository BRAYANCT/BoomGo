<?php


namespace App\Repositories;


use App\PaymentMethod;
use Illuminate\Database\Eloquent\Builder;

class PaymentMethodRepositoryImpl extends GenericRepositoryImpl implements IPaymentMethodRepository
{

    public function __construct()
    {
        $this-> model = new PaymentMethod();
    }


    /**
     * Obtiene los parametros de la consulta
     *
     * @param  array $parameters
     * @param  Object $query Consulta
     * @return Object
     */
    public function getParametersQuery($parameters,$query)
    {

        if(count($parameters) > 0) {
            foreach ($parameters as $index => $item){

                //filtra el negocio
                if($item[0] == 'business_id'){
                    $symbol = $item[1];
                    $businessId = $item[2];

                    $query = $query->whereHas('businesses', function (Builder $query) use($symbol,$businessId) {
                        $query->where('businesses.id',$symbol, $businessId );
                    });
                    unset($parameters[$index]);
                }
            }
        }
//        dd($query->toSql());

        $query = parent::getParametersQuery($parameters,$query);
        return $query;
    }
}

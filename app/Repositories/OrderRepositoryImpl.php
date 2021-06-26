<?php


namespace App\Repositories;


use App\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class OrderRepositoryImpl extends GenericRepositoryImpl implements IOrderRepository
{

    public function __construct()
    {
        $this-> model = new Order();
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

                if($item[0] == 'user_id'){
                    $symbol = $item[1];
                    $userId = $item[2];
                    $query = $query->whereHas('orderGroup', function (Builder $query)use($symbol,$userId) {
                        $query->where('order_groups.user_id',$symbol,$userId);
                    });
                    unset($parameters[$index]);
                }

            }
        }

//        \Log::debug($query->toSql());

        $query = parent::getParametersQuery($parameters,$query);
        return $query;
    }

}

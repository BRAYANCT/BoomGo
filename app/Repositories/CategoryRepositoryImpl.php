<?php


namespace App\Repositories;


use App\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class CategoryRepositoryImpl extends GenericRepositoryImpl implements ICategoryRepository
{

    public function __construct()
    {
        $this-> model = new Category();
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


                if($item[0] == 'where_has_products'){
                    $parametersWhereHas = $item[1];
                    $query = $query->whereHas('products', function (Builder $query)use($parametersWhereHas) {
                        $query->where($parametersWhereHas);
                    });
                    unset($parameters[$index]);
                }

                // filtra todas las categorias de un producto
                if($item[0] == 'product_business'){
//                    Log::debug("entro a product business");
                    $businessId = $item[1];

                    // obtiene todas las categorias de los productos de un negocio
                    $productCategories = Category::whereHas('products', function (Builder $query)use($businessId) {
                        $query->where('business_id',$businessId);
                    })->get();

//                    Log::debug("productCategories: ".json_encode($productCategories));
                    // trae todas las categorias del negocio
//                    $query = $query->whereIn('id',$productCategories->pluck('id')->toArray());

                    $query = $query->where(function($query) use($productCategories) {
                        $query->whereIn('id',$productCategories->pluck('id')->toArray());

                        // trae las categorias padre de los productos del negocio
                        foreach($productCategories as $category){
//                        Log::debug("entro a foreach".$category->level);
                            if($category->level > 1){
                                $query->orWhere(function($query1) use($category) {
                                    $query1->where('code', $category->code)
                                        ->where('level', '<', $category->level);
                                });
                            }
                        }
                    });


                    unset($parameters[$index]);
                }

            }
        }

//        Log::debug($query->toSql());

        $query = parent::getParametersQuery($parameters,$query);
        return $query;
    }


}

<?php


namespace App\Repositories;


use App\Category;
use App\Exceptions\DataBaseGenericException;
use App\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductRepositoryImpl extends GenericRepositoryImpl implements IProductRepository
{

    public function __construct()
    {
        $this-> model = new Product();
    }

    /**
     * Obtiene la lista de productos que tiene permitido ver el usuario authenticado segun su role
     * de nivel superior
     *
     * @param array $parameters
     * @param array $relationshipNames
     * @param bool $trashed
     * @return collection Product::class
     */
    public function findAllAllowedForAuthUser($parameters=[],$relationshipNames=[],$trashed = false)
    {
        //Obtiene el usuario autenticado
        $authUser = Auth::user();

        $query = $this-> model;

        $query = $this->getRelationshipQuery($relationshipNames,$query);

        if($trashed){
            $query = $query->withTrashed();
        }

        // si no es administrador del sistema
        if(!$authUser->canChooseBusiness()){
            $query = $query->where('business_id',$authUser->business ? $authUser->business->id : -1 );
        }

        $query = $this->getParametersQuery($parameters,$query);
        return $query ->get();
    }

    /**
     * Elimina y registra las nuevas categorias para un producto
     *
     * @param Product $product
     * @param array $data Arreglo con los datos
     * @return boolean
     */
    public function syncCategories(Product $product, array $data)
    {
        try{
            $product->categories()->sync($data['categories_id']);

        }catch (\Exception $e) {
            throw new DataBaseGenericException($e->getMessage());
        }
        return true;
    }

    /**
     * Registra las imagenes
     *
     * @param Product $product
     * @param array $data Arreglo con los datos
     * @return boolean
     */
    public function insertImages(Product $product, array $data)
    {
        try{

            $imagesName = $data['images_name'];

            $insertData = array();

            foreach ($imagesName as $index => $name){
                $data = [
                    'imageable_id' => $product->id ,
                    'imageable_type' => Product::class,
                    'name'=>$name
                ];

                array_push($insertData,$data);
            }

            $product->images()->insert($insertData);

        }catch (\Exception $e) {
            throw new DataBaseGenericException($e->getMessage());
        }
        return true;
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


                if($item[0] == 'search_text'){
                    $searchText = $item[1];
                    $query = $query->where(function($querySearch)use($searchText) {
                            $querySearch->where('name', 'like', '%'.$searchText.'%')
                                ->OrWhere('description', 'like', '%'.$searchText.'%');
                        });

                    unset($parameters[$index]);
                }


                if($item[0] == 'orderBy')
                {
                    if($item[1] == 'last'){
                        $query = $query->orderBy('created_at', 'desc');
                        unset($parameters[$index]);
                    }elseif($item[1] == 'recommended'){
                        $query = $query->orderBy(\DB::raw('(select AVG(score) from reviews where businesses.id = reviews.model_id)'), 'desc');
                        unset($parameters[$index]);

                    }elseif($item[1] == 'higher_price'){
                        $query = $query->orderBy('price', 'desc');
                        unset($parameters[$index]);
                    }elseif($item[1] == 'lower_price'){
                        $query = $query->orderBy('price', 'asc');
                        unset($parameters[$index]);
                    }
                }

                if($item[0] == 'offer' || $item[0] == 'best_offer')
                {
                    //verdadero o falso
                    $value = $item[1];

                    if($value){


                        $query = $query->where(function($query) {

                            // si el rango de fechas esta activo verifica que se encuentre dentro de fechas disponibles
                            $query->where(function($query) {
                                $query->where('offer_date_range', true)
                                    ->whereBetween(DB::Raw('CURRENT_DATE'), [DB::Raw('offer_start_date'), DB::Raw('offer_end_date')]);
                            });

                            // si el rango de fechas no esta activo verifica que el precio no esta no sea nulo
                            $query->orWhere(function($query) {
                                $query = $query->where('offer_date_range', false)
                                            ->whereNotNull('offer_price');
                            });

                        });

                        if($item[0] == 'best_offer'){
                            $query = $query->orderBy(DB::Raw('(price - offer_price)'), 'desc');
                        }
                    }else{

                        $query = $query->where(function($query) {

                            $query->orWhere(function($query) {
                                $query->where('offer_date_range', false)
                                    ->whereNull('offer_price');
                            });

                            $query->orWhere(function($query) {
                                $query->where('offer_date_range', true)
                                    ->whereNotBetween(DB::Raw('CURRENT_DATE'), [DB::Raw('offer_start_date'), DB::Raw('offer_end_date')]);
                            });
                        });

                    }
                    unset($parameters[$index]);
                }

                if($item[0] == 'category_id'){
                    $categoryId = $item[1];
                    $query = $query->whereHas('categories', function (Builder $query)use($categoryId) {
                        $query->where('categories.id',$categoryId);
                    });
                    unset($parameters[$index]);
                }

                if($item[0] == 'category_id_with_childs'){
                    $symbol = $item[1];
                    $categoryId = $item[2];

                    $query = $query->whereHas('categories', function (Builder $query) use($symbol,$categoryId) {
                        $query->where('categories.id',$symbol, $categoryId );

                        $category = Category::find($categoryId);
                        if($category){
                            $query->orWhere(function($query) use($symbol,$category) {
                                $query->where('parent_id', $symbol ,$category->id)
                                    ->where('level', '>', $category->level);
                            });
                        }
                    });
                    unset($parameters[$index]);
                }

            }
        }

        $query = parent::getParametersQuery($parameters,$query);

//        \Log::debug($query->toSql());

        return $query;
    }

}

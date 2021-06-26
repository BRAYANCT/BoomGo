<?php


namespace App\Repositories;


use App\Business;
use App\Category;
use App\Exceptions\DataBaseGenericException;
use Illuminate\Database\Eloquent\Builder;

class BusinessRepositoryImpl extends GenericRepositoryImpl implements IBusinessRepository
{

    public function __construct()
    {
        $this-> model = new Business();
    }

    /**
     * Pone todos los tipos de proveedores nuevos y borra los antiguos
     *
     * @param Business $business
     * @param array $data
     * @return Boolean
     */
    public function syncProviderTypes(Business $business,$data)
    {
        try {
            $dataSync = array();

            foreach ($data as $clave => $valor){
                if(!empty($valor)){
                    array_push($dataSync,$valor);
                }
            }

            $business->providerTypes()->sync($dataSync);
        }catch (\Exception $e) {
            throw new DataBaseGenericException($e->getMessage());
        }
        return true;
    }

    /**
     * Registra las imagenes
     *
     * @param Business $business
     * @param array $data Arreglo con los datos
     * @return boolean
     */
    public function insertImages(Business $business, array $data)
    {
        try{

            $imagesName = $data['images_name'];

            $insertData = array();

            foreach ($imagesName as $index => $name){
                $data = [
                    'imageable_id' => $business->id ,
                    'imageable_type' => Business::class,
                    'name'=>$name
                ];

                array_push($insertData,$data);
            }

            $business->images()->insert($insertData);

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
                    $query =
                        $query->where(function($query)use($searchText) {

                            $query->where('name', 'like', '%'.$searchText.'%')
                                ->OrWhere('description', 'like', '%'.$searchText.'%')
                                ->OrWhere(function($query)use($searchText){
                                    $query->whereHas('category', function (Builder $query) use($searchText) {
                                        $query->where('categories.name','like', "%{$searchText}%" )
                                            ->OrWhere(function($query)use($searchText) {
                                                $query->whereHas('parent', function (Builder $query) use($searchText) {
                                                    $query->where('name','like', "%{$searchText}%" );
                                                });
                                            });
                                    });
                                })
                                ->OrWhere(function($query)use($searchText){

                                    $query->whereHas('products.categories', function ($query) use($searchText) {
                                        $query->where('products.name', 'like', '%'.$searchText.'%')
                                            ->OrWhere('products.description', 'like', '%'.$searchText.'%')
                                            ->OrWhere(function($query)use($searchText) {

                                                $query->where('categories.name','like', "%{$searchText}%" )
                                                    ->OrWhere(function($query)use($searchText) {
                                                        $query->whereHas('parent', function (Builder $query) use($searchText) {
                                                            $query->where('name','like', "%{$searchText}%" );
                                                        });
                                                    });
                                        });
                                    });

                                });
                        });

                    unset($parameters[$index]);
                }


                if($item[0] == 'orderBy'){
                    if($item[1] == 'last'){
                        $query = $query->orderBy('created_at', 'desc');
                        unset($parameters[$index]);
                    }elseif($item[1] == 'recommended'){
                        $query = $query->orderBy(\DB::raw('(select AVG(score) from reviews where businesses.id = reviews.model_id)'), 'desc');
                        unset($parameters[$index]);
                    }
                }

                if($item[0] == 'provider_type_id'){
                    $providerTypeId = $item[1];
                    $query = $query->whereHas('providerTypes', function ($query)use($providerTypeId) {
                        $query->where('provider_types.id',$providerTypeId);
                    });
                    unset($parameters[$index]);
                }

                if($item[0] == 'province_id'){
                    $provinceId = $item[1];
                    $query = $query->whereHas('district', function ($query)use($provinceId) {
                        $query->where('districts.province_id',$provinceId);
                    });
                    unset($parameters[$index]);
                }

                //filtra la categoria y todos sus hijos
                if($item[0] == 'category_id_with_childs'){
                    $symbol = $item[1];
                    $categoryId = $item[2];

                    $query = $query->whereHas('category', function (Builder $query) use($symbol,$categoryId) {
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


                if($item[0] == 'distance'){

                    $distance = $item[1]*1000;//distancia en metros
                    $latitude = $item[2];
                    $longitude = $item[3];

//                    $query = $query->select('*',\DB::Raw(
//                        "(6378137 * 2 * ATAN2(SQRT(POW(SIN((('-12.046367'-latitude) * PI() / 180)/2),2)+
//COS(latitude * PI() / 180 ) * COS('-12.046367'*PI()/180 )*
//POW(SIN((('-77.042853'-longitude)*PI()/180)/2),2)), SQRT(1-POW(SIN((('-12.046367'-latitude) * PI() / 180)/2),2)+
//COS(latitude * PI() / 180 ) * COS('-12.046367'*PI()/180 )*
//POW(SIN((('-77.042853'-longitude)*PI()/180)/2),2)))) as distance"
//                    ))
//                        ->havingRaw('distance <= ?',[500]);

                    $query = $query->whereRaw(
                        "(6378137 * 2 * ATAN2(SQRT(POW(SIN((('{$latitude}'-latitude) * PI() / 180)/2),2)+
COS(latitude * PI() / 180 ) * COS('{$latitude}'*PI()/180 )*
POW(SIN((('{$longitude}'-longitude)*PI()/180)/2),2)), SQRT(1-POW(SIN((('{$latitude}'-latitude) * PI() / 180)/2),2)+
COS(latitude * PI() / 180 ) * COS('{$latitude}'*PI()/180 )*
POW(SIN((('{$longitude}'-longitude)*PI()/180)/2),2)))) <= {$distance}"
                    );

                    unset($parameters[$index]);
                }

            }
        }
//        dd($query->toSql());


        $query = parent::getParametersQuery($parameters,$query);
        return $query;
    }







}

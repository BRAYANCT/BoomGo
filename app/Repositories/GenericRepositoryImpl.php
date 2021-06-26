<?php
namespace App\Repositories;

use App\Exceptions\DataBaseGenericException;
use App\Repositories\IGenericRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;


class GenericRepositoryImpl implements IGenericRepository {

    public $model;


    /**
     * Obtiene un registro por id.
     *
     * @param integer $id
     * @param array $relationshipNames Nombres de las relaciones que se traera
     * @param boolean $trashed
     * @return Model::class
     */
    public function find($id,$relationshipNames=[],$trashed = false)
    {
        $query = $this-> model;

        $query = $this->getRelationshipQuery($relationshipNames,$query);

        if($trashed){
            $query = $query->withTrashed();
        }

        return $query->find($id);
    }

    /**
     * Obtiene un registro por el valor de una columna
     *
     * @param  string $columnName
     * @param  string $value
     * @param  array $relationshipNames Nombres de las relaciones que se traera
     * @param  boolean $trashed
     * @return Model::class
     */
    public function findBy($columnName,$value,$relationshipNames=[],$trashed = false){

        $query = $this-> model;

        $query = $this->getRelationshipQuery($relationshipNames,$query);

        if($trashed){
            $query = $query->withTrashed();
        }
        $query = $query->where($columnName,$value);

        return $query->first();
    }


    /**
     * Obtiene un registro por los filtros where enviados
     *
     * @param  array $parameters
     * @param  array $relationshipNames Nombres de las relaciones que se traera
     * @param  boolean $trashed
     * @return Model::class
     */
    public function findByParameters($parameters,$relationshipNames=[],$trashed = false){

        $query = $this-> model;

         $query = $this->getRelationshipQuery($relationshipNames,$query);

        if($trashed){
            $query = $query->withTrashed();
        }

        foreach ($parameters as $key => $value) {
            if(!empty($value)){
                $query = $query-> where($key,$value);
            }
        }
        return $query ->first();
    }

    /**
     * Obtiene un registro por los filtros where enviados con diferentes condiciones dentro de array anidados
     *
     * @param  array $parameters se pueden enviar diferentes condiciones en array anidados
     * @param  array $relationshipNames Nombres de las relaciones que se traera
     * @param  boolean $trashed
     * @return Model::class
     */
    public function findWhere($parameters,$relationshipNames=[],$trashed = false){
        $query = $this-> model;

        $query = $this->getRelationshipQuery($relationshipNames,$query);

        if($trashed){
            $query = $query->withTrashed();
        }

        $query = $this->getParametersQuery($parameters,$query);

        return $query ->first();
    }


    /**
     * Obtiene los ultimos registros
     *
     * @param  string $numberRows cantidad de registros
     * @param  string $columnName
     * @param  array $relationshipNames Nombres de las relaciones que se traera
     * @param  boolean $trashed
     * @return Model::class
     */
    public function  findLasts($numberRows=5,$columnName="created_at",$relationshipNames=[],$trashed = false){

        $query = $this-> model;

        $query = $this->getRelationshipQuery($relationshipNames,$query);

        if($trashed){
            $query = $query->withTrashed();
        }

        return $query-> orderBy($columnName, 'desc')
                            ->limit($numberRows)
                            ->get();
    }

    /**
     * Obtiene todos los registro.
     *
     * @param  array $relationshipNames Nombres de las relaciones que se traera
     * @param  boolean $trashed
     * @return Illuminate\Support\Collection(Model::class)
     */
    public function findAll($relationshipNames=[],$trashed = false)
    {
        $query = $this-> model;

        $query = $this->getRelationshipQuery($relationshipNames,$query);

        if($trashed){
            $query = $query->withTrashed();
        }

        return $query->get();
    }

    /**
     * Obtiene todos los registro incluidos los de softdelete.
     *
     * @param  array $relationshipNames Nombres de las relaciones que se traera
     * @return Illuminate\Support\Collection(Model::class)
     */
    public function findAllWithTrashed($relationshipNames=[]){

        $query = $this-> model;

        $query = $this->getRelationshipQuery($relationshipNames,$query);

        return $query->withTrashed()->get();
    }

    /**
     * Obtiene todos los registro con softdelete.
     *
     * @param  array $relationshipNames Nombres de las relaciones que se traera
     * @return Illuminate\Support\Collection(Model::class)
     */
    public function findAllTrashed($relationshipNames=[]){

        $query = $this-> model;

        $query = $this->getRelationshipQuery($relationshipNames,$query);

        return $query->onlyTrashed()->get();
    }

    /**
     * Obtiene todos los registro con las relaciones enviadas
     *
     * @param array $relationshipNames
     * @param  boolean $trashed
     * @return Illuminate\Support\Collection(Model::class)
     */
    public function findAllWithRelationship($relationshipNames,$trashed = false){

        $query = $this-> model;

        if($trashed){
            $query = $query->withTrashed();
        }

        $query = $this->getRelationshipQuery($relationshipNames,$query);

        return $query->get();
    }


    /**
     * Obtiene varios registro por el valor de una columna
     *
     * @param  string $columnName
     * @param  string $value
     * @param  array $relationshipNames Nombres de las relaciones que se traera
     * @param  boolean $trashed
     * @return Illuminate\Support\Collection(Model::class)
     */
    public function findAllBy($columnName,$value,$relationshipNames=[],$trashed = false){

        $query = $this-> model;

        $query = $this->getRelationshipQuery($relationshipNames,$query);

        if($trashed){
            $query = $query->withTrashed();
        }

        return $query->where($columnName,$value)->get();
    }


    /**
     * Obtiene varios registros por los filtros where enviados
     *
     * @param  array $parameters
     * @param  array $relationshipNames Nombres de las relaciones que se traera
     * @param  boolean $trashed
     * @return Illuminate\Support\Collection(Model::class)
     */
    public function findAllByParameters($parameters,$relationshipNames=[],$trashed = false){
        $query = $this-> model;

        $query = $this->getRelationshipQuery($relationshipNames,$query);

        if($trashed){
            $query = $query->withTrashed();
        }

        foreach ($parameters as $key => $value) {
            if(!empty($value)){
                $query = $query-> where($key,$value);
            }

        }
        return $query ->get();
    }

     /**
     * Obtiene varios registro por los filtros where enviados con diferentes condiciones dentro de array anidados
     *
     * @param  array $parameters se pueden enviar diferentes condiciones en array anidados
     * @param  array $relationshipNames Nombres de las relaciones que se traera
     * @param  boolean $trashed
     * @return Collection (Model::class)
     */
    public function findAllWhere($parameters,$relationshipNames=[],$trashed = false){
        $query = $this-> model;

        $query = $this->getRelationshipQuery($relationshipNames,$query);

        if($trashed){
            $query = $query->withTrashed();
        }

        $query = $this->getParametersQuery($parameters,$query);

        return $query ->get();
    }


    /**
     * Obtiene varios registro que son diferentes al valor de una columna
     *
     * @param  string $columnName
     * @param  string $value
     * @param  array $relationshipNames Nombres de las relaciones que se traera
     * @param  boolean $trashed
     * @return Illuminate\Support\Collection(Model::class)
     */
    public function findAllDiffBy($columnName,$value,$relationshipNames=[],$trashed = false){

        $query = $this-> model;

        $query = $this->getRelationshipQuery($relationshipNames,$query);

        if($trashed){
            $query = $query->withTrashed();
        }

        return $query->where($columnName,'!=',$value)->get();
    }


    /**
     * Obtiene varios registros que sean iguales a los valores enviados de una columna
     *
     * @param  string $columnName
     * @param  array $array
     * @param  array $relationshipNames Nombres de las relaciones que se traera
     * @param  boolean $trashed
     * @return Illuminate\Support\Collection(Model::class)
     */
    public function findAllWhereIn($columnName,$array,$relationshipNames=[],$trashed = false){

        $query = $this-> model;

        $query = $this->getRelationshipQuery($relationshipNames,$query);

        if($trashed){
            $query = $query->withTrashed();
        }

        return $query->whereIn($columnName,$array)->get();
    }

    /**
     * Obtiene varios registros que son diferentes a los valores enviados de una columna
     *
     * @param  string $columnName
     * @param  array $array
     * @param  array $relationshipNames Nombres de las relaciones que se traera
     * @param  boolean $trashed
     * @return Illuminate\Support\Collection(Model::class)
     */
    public function findAllWhereNotIn($columnName,$array,$relationshipNames=[],$trashed = false){

        $query = $this-> model;

        $query = $this->getRelationshipQuery($relationshipNames,$query);

        if($trashed){
            $query = $query->withTrashed();
        }

        return $query->whereNotIn($columnName,$array)->get();
    }


    /**
     * Obtiene todos los registro con paginacion.
     *
     * @param array $data parametros para los filtro
     * @param  array $relationshipNames Nombres de las relaciones que se traera
     * @param  boolean $trashed
     * @return Illuminate\Support\Collection(Model::class)
     */
    public function findAllWithPagination($data=[],$relationshipNames=[],$trashed = false)
    {
        $query = $this-> model;

        $perPage = "";
        if(isset($data['perPage'])){
            $perPage = $data['perPage'];
            unset($data['perPage']);
        }

        $query = $this->getRelationshipQuery($relationshipNames,$query);

        if($trashed){
            $query = $query->withTrashed();
        }

        $query = $this-> getParametersQuery($data,$query);

        if(!empty($perPage)){
            return $query->paginate($perPage);
        }

        return $query->paginate();
    }

    /**
     * Obtiene todos los registro por un arreglo de Id.
     *
     * @param array $idArray Arreglo de Ids
     * @return Illuminate\Support\Collection(Model::class)
     */
    public function findAllByIdArray($idArray)
    {
        return $this-> model->whereIn('id',$idArray)->get();
    }


    /**
     * Carga las relaciones de un modelo
     *
     * @param Model:class $model
     * @param array $relationshipNames Nombres de las relaciones que se traera
     * @return Model:class
     */
    public function load($model,$relationshipNames)
    {
        $relationsToLoad =array();

        foreach ($relationshipNames as $index => $value){
            if(is_string ($value)){
                $relation = preg_split("/_/", $value);
                if(count($relation) == 2){
                    $relationName = $relation[0];
                    if($relation[1] == 'trashed'){

                        $relationsToLoad[$relation[0]] = function ($query) {
                            $query->withTrashed();
                        };
                        unset($relationshipNames[$index]);
                    }
                }
            }
        }

        return $model->load(array_merge($relationshipNames, $relationsToLoad));
    }

    /**
     * Obtiene la cantidad de registros
     *
     * @param  boolean $trashed
     * @return integer
     */
    public function count($trashed= false){

        $query = $this-> model;

        if($trashed){
            $query = $query->withTrashed();
        }

        return $query->count();
    }

    /**
     * Obtiene la cantidad de registros filtrado
     *
     * @param  string $columnName
     * @param  string $value
     * @param  boolean $trashed
     * @return integer
     */
    public function countBy($columnName,$value,$trashed= false){

        $query = $this-> model;

        if($trashed){
            $query = $query->withTrashed();
        }
        return $query->where($columnName,$value)->count();
    }

    /**
     * Guarda el registro en la base de datos
     *
     * @param Model::class $model
     * @return boolean
    */
    public function save($model)
    {
        try {
            $model->save();
        }catch (\Exception $e) {
            throw new DataBaseGenericException($e->getMessage());
        }
        return true;
    }

    /**
     * Guarda el registro en la base de datos
     *
     * @param array $data
     * @return Model:class
    */
    public function create($data)
    {
        $model = null;
        try {
            $model= $this-> model->create($data);
        }catch (\Exception $e) {
            throw new DataBaseGenericException($e->getMessage());
        }
        return $model;
    }

    /**
     * Actualiza un registro
     *
     * @param array $data Arreglo con los datos a actualizar
     * @return Model:class
    */
    public function update($data)
    {
        $model = null;
        try {
            $model = $this->find($data['id']);
            $model->update($data);
        }catch (\Exception $e) {
            throw new DataBaseGenericException($e->getMessage());
        }
        return $model;
    }

    /**
     * Borra un registro
     *
     * @param  Model::class $model
     * @return boolean
    */
    public function delete($model)
    {
        try {
            $model-> delete();
        }catch (\Exception $e) {
            throw new DataBaseGenericException($e->getMessage());
        }
        return true;
    }

    /**
     * Borra uno o mas registro por el id
     *
     * @param  array integer $arrayIds
     * @return boolean
    */
    public function destroy($arrayIds)
    {
        try {
            $result = $this->model->destroy($arrayIds);
        }catch (\Exception $e) {
           throw new DataBaseGenericException($e->getMessage());
        }
        return $result == count($arrayIds);
    }

    /**
     * Obtiene las relaciones del modelo
     *
     * @param array $relationshipNames
     * @param Object $query
     * @return Object
     */
    public function getRelationshipQuery($relationshipNames,$query){
        if(count($relationshipNames) > 0) {
            foreach ($relationshipNames as $index => $value){
                $relation = preg_split("/_/", $value);
                if(count($relation) == 2){
                    $relationName = $relation[0];
                    if($relation[1] == 'trashed'){
                        $query = $query->with([ $relationName=> function ($query) {
                            $query->withTrashed();
                        }]);
                        unset($relationshipNames[$index]);
                    }
                }
            }
            return $query-> with($relationshipNames);
        }
        return $query;
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

                if($item[0] == 'limit'){
                    $query = $query-> limit($item[1]);
                    unset($parameters[$index]);
                }

                if($item[0] == 'orderBy'){
                    $query = $query-> orderBy($item[1],$item[2]);
                    unset($parameters[$index]);
                }

                if($item[0] == 'whereIn'){
                    $query = $query-> whereIn($item[1],$item[2]);
                    unset($parameters[$index]);
                }

                if($item[0] == 'whereNotIn'){
                    $query = $query-> whereNotIn($item[1],$item[2]);
                    unset($parameters[$index]);
                }

                if($item[0] == 'has'){
                    $query = $query-> has($item[1]);
                    unset($parameters[$index]);
                }

                if($item[0] == 'doesntHave'){
                    $query = $query-> doesntHave($item[1]);
                    unset($parameters[$index]);
                }

                if($item[0] == 'whereHasMorph'){
                    $query = $query-> whereHasMorph($item[1],$item[2]);
                    unset($parameters[$index]);
                }

            }
            return $query-> where($parameters);
        }
        return $query;
    }


}
?>

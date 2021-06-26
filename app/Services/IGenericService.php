<?php
namespace App\Services;


interface IGenericService{

    /**
     * Obtiene un registro por id.
     *
     * @param integer $id
     * @param array $relationshipNames Nombres de las relaciones que se traera
     * @param boolean $trashed
     * @return Model::class
     */
    public function find($id,$relationshipNames=[],$trashed = false);

    /**
     * Obtiene un registro por el valor de una columna
     *
     * @param  string $columnName
     * @param  string $value
     * @param  array $relationshipNames Nombres de las relaciones que se traera
     * @param  boolean $trashed
     * @return Model::class
     */
    public function findBy($columnName,$value,$relationshipNames=[],$trashed = false);



    /**
     * Obtiene un registro por los filtros where enviados
     *
     * @param  array $parameters
     * @param  array $relationshipNames Nombres de las relaciones que se traera
     * @param  boolean $trashed
     * @return Model::class
     */
    public function findByParameters($parameters,$relationshipNames=[],$trashed = false);


    /**
     * Obtiene un registro por los filtros where enviados con diferentes condiciones dentro de array anidados
     *
     * @param  array $parameters se pueden enviar diferentes condiciones en array anidados
     * @param  array $relationshipNames Nombres de las relaciones que se traera
     * @param  boolean $trashed
     * @return Model::class
     */
    public function findWhere($parameters,$relationshipNames=[],$trashed = false);


    /**
     * Obtiene los ultimos registros
     *
     * @param  string $numberRows cantidad de registros
     * @param  string $columnName
     * @param  array $relationshipNames Nombres de las relaciones que se traera
     * @param  boolean $trashed
     * @return Model::class
     */
    public function  findLasts($numberRows=5,$columnName="created_at",$relationshipNames=[],$trashed = false);

    /**
     * Obtiene todos los registro.
     *
     * @param  array $relationshipNames Nombres de las relaciones que se traera
     * @param  boolean $trashed
     * @return Illuminate\Support\Collection(Model::class)
     */
    public function findAll($relationshipNames=[],$trashed = false);


    /**
     * Obtiene todos los registro incluidos los de softdelete.
     *
     * @param  array $relationshipNames Nombres de las relaciones que se traera
     * @return Illuminate\Support\Collection(Model::class)
     */
    public function findAllWithTrashed($relationshipNames=[]);

    /**
     * Obtiene todos los registro con softdelete.
     *
     * @param  array $relationshipNames Nombres de las relaciones que se traera
     * @return Illuminate\Support\Collection(Model::class)
     */
    public function findAllTrashed($relationshipNames=[]);

    /**
     * Obtiene todos los registro con las relaciones enviadas
     *
     * @param array $relationshipNames
     * @param  boolean $trashed
     * @return Illuminate\Support\Collection(Model::class)
     */
    public function findAllWithRelationship($relationshipNames,$trashed = false);


    /**
     * Obtiene varios registro por el valor de una columna
     *
     * @param  string $columnName
     * @param  string $value
     * @param  array $relationshipNames Nombres de las relaciones que se traera
     * @param  boolean $trashed
     * @return Illuminate\Support\Collection(Model::class)
     */
    public function findAllBy($columnName,$value,$relationshipNames=[],$trashed = false);

    /**
     * Obtiene varios registros por los filtros where enviados
     *
     * @param  array $parameters
     * @param  array $relationshipNames Nombres de las relaciones que se traera
     * @param  boolean $trashed
     * @return Illuminate\Support\Collection(Model::class)
     */
    public function findAllByParameters($parameters,$relationshipNames=[],$trashed = false);


    /**
     * Obtiene varios registro por los filtros where enviados con diferentes condiciones dentro de array anidados
     *
     * @param  array $parameters se pueden enviar diferentes condiciones en array anidados
     * @param  array $relationshipNames Nombres de las relaciones que se traera
     * @param  boolean $trashed
     * @return Illuminate\Support\Collection(Model::class)
     */
    public function findAllWhere($parameters,$relationshipNames=[],$trashed = false);


    /**
     * Obtiene varios registro que son diferentes al valor de una columna
     *
     * @param  string $columnName
     * @param  string $value
     * @param  array $relationshipNames Nombres de las relaciones que se traera
     * @param  boolean $trashed
     * @return Illuminate\Support\Collection(Model::class)
     */
    public function findAllDiffBy($columnName,$value,$relationshipNames=[],$trashed = false);



     /**
     * Obtiene varios registros que sean iguales a los valores enviados de una columna
     *
     * @param  string $columnName
     * @param  array $array
     * @param  array $relationshipNames Nombres de las relaciones que se traera
     * @param  boolean $trashed
     * @return Illuminate\Support\Collection(Model::class)
     */
    public function findAllWhereIn($columnName,$array,$relationshipNames=[],$trashed = false);


    /**
     * Obtiene varios registros que son diferentes a los valores enviados de una columna
     *
     * @param  string $columnName
     * @param  array $array
     * @param  array $relationshipNames Nombres de las relaciones que se traera
     * @param  boolean $trashed
     * @return Illuminate\Support\Collection(Model::class)
     */
    public function findAllWhereNotIn($columnName,$array,$relationshipNames=[],$trashed = false);


    /**
     * Obtiene todos los registro con paginacion.
     * @param array $data parametros para los filtro
     * @param  array $relationshipNames Nombres de las relaciones que se traera
     * @param  boolean $trashed
     * @return Illuminate\Support\Collection(Model::class)
     */
    public function findAllWithPagination($data=[],$relationshipNames=[],$trashed = false);


    /**
     * Carga las relaciones de un modelo
     * @param Model:class $model
     * @param array $relationshipNames Nombres de las relaciones que se traera
     * @return Model:class
     */
    public function load($model,$relationshipNames);

    /**
     * Obtiene la cantidad de registros
     *
     * @param  boolean $trashed
     * @return integer
     */
    public function count($trashed= false);


    /**
     * Obtiene la cantidad de registros filtrado
     *
     * @param  string $columnName
     * @param  string $value
     * @param  boolean $trashed
     * @return integer
    */
    public function countBy($columnName,$value,$trashed= false);


    /**
     * Guarda el registro en la base de datos
     *
     * @param Model::class $model
     * @return boolean
    */
    public function save($model);

    /**
     * Guarda el registro en la base de datos
     *
     * @param array $data
     * @return Model:class
    */
    public function create($data);


    /**
     * Actualiza un registro
     *
     * @param array $data Arreglo con los datos a actualizar
     * @return Model:class
    */
    public function update($data);


    /**
     * Borra un registro
     *
     * @param  Model::class $model
     * @return boolean
    */
    public function delete($model);


    /**
     * Borra uno o mas registro por el id
     *
     * @param  array integer $arrayIds
     * @return boolean
    */
    public function destroy($arrayIds);

    /**
     * Obtiene el nombre del storage de los archivos
     *
     * @param bool $public
     * @return string
     */
    public function getFileStorage($public = false);

    /**
     * Obtiene el nombre del storage
     *
     * @param bool $public
     * @return string
     */
    public function getStorageName($public = false);

    /**
     * Obtiene el nombre del storage
     *
     * @return string
     */
    public function getStorageAbsolutePath();

}
?>

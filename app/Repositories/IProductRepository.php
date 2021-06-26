<?php


namespace App\Repositories;


use App\Product;
use Illuminate\Support\Collection;

interface IProductRepository
{

    /**
     * Obtiene la lista de productos que tiene permitido ver el usuario authenticado segun su role
     * de nivel superior
     *
     * @param array $parameters
     * @param array $relationshipNames
     * @param bool $trashed
     * @return collection Product::class
     */
    public function findAllAllowedForAuthUser($parameters=[],$relationshipNames=[],$trashed = false);

    /**
     * Elimina y registra las nuevas categorias para un producto
     *
     * @param Product $product
     * @param array $data Arreglo con los datos
     * @return boolean
     */
    public function syncCategories(Product $product, array $data);

    /**
     * Registra las imagenes
     *
     * @param Product $product
     * @param array $data Arreglo con los datos
     * @return boolean
     */
    public function insertImages(Product $product, array $data);
}

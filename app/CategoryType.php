<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryType extends Model
{
    protected $table = 'category_types';


    /***********************************************************************/
    /**************************** Relationships ****************************/
    /***********************************************************************/

    public function categories()
    {
        return $this->hasMany(Category::class,'category_type_id','id');
    }


    /***********************************************************************/
    /**************************** Functions ********************************/
    /***********************************************************************/

    /**
     * Verifica si el tipo de categoria es negocio
     *
     * @param
     * @return boolean
     */
    public function isBusiness()
    {
        return $this -> name == config('constant.categorytype.business_id');
    }

    /**
     * Verifica si el tipo de categoria es producto
     *
     * @param
     * @return boolean
     */
    public function isProduct()
    {
        return $this -> name == config('constant.categorytype.product_id');
    }

}

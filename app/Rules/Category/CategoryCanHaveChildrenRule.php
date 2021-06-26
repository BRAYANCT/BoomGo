<?php

namespace App\Rules\Category;

use App\Category;
use Illuminate\Contracts\Validation\Rule;

class CategoryCanHaveChildrenRule implements Rule
{

    private $childCategoryId;
    private $categoryTypeId;

    /**
     * Create a new rule instance.
     *
     * @param $childCategoryId 'id de la categoria hija'
     * @param $categoryTypeId 'id del tipo de categoria'
     * @return void
     */
    public function __construct($childCategoryId,$categoryTypeId)
    {
        $this->childCategoryId = $childCategoryId;
        $this->categoryTypeId = $categoryTypeId;
    }

    /**
     * Verifica si la categoria puede tener categorias hijas
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $categoryId)
    {
        if($this->childCategoryId == $categoryId){
            return false;
        }

        $category = Category::where('id',$categoryId)
                            ->where('category_type_id',$this->categoryTypeId)
                            ->first();

        if(!$category){
            return false;
        }

        return $category->canHaveChildren();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El valor del campo :attribute no es válido.';
    }
}

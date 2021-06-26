<?php

namespace App\Rules\Category;

use App\Category;
use Illuminate\Contracts\Validation\Rule;

class CategoryCanRegisterToModelRule implements Rule
{
    private $categoryTypeId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($categoryTypeId)
    {
        $this->categoryTypeId = $categoryTypeId;
    }

    /**
     * Verifica si la categoria se puede registrar para un modelo
     *
     * @param string $attribute
     * @param integer $categoryId
     * @return bool
     */
    public function passes($attribute, $categoryId)
    {
        $category = Category::where('id',$categoryId)
            ->where('category_type_id',$this->categoryTypeId)
            ->first();

        // existe la categoria
        if(!$category){
            return false;
        }

//        la categoria no puede tener hijos
        return !count($category->childs)>0;
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

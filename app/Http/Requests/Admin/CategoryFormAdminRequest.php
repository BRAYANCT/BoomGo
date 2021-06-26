<?php

namespace App\Http\Requests\Admin;

use App\Rules\Category\CategoryCanHaveChildrenRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class CategoryFormAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = "";

        $data = $this-> validationData();

//        Log::debug($data);

        $accion = "";
        if(isset($data['_method'])){
            $accion =  $data['_method'];
        }

        //obtiene el id cuando está actualizando
        if($accion == "PUT"){
            $id = $this->route('category')->id;
        }

        $rules = array();

        $rules['category_type_id'] = ['required','exists:category_types,id'];

        $rules['name'] = [
            'required',
            'string','max:'.config('constant.attribute.name.max'),
//            'unique:categories,name,'.($accion == "PUT" ? $id : 'NULL').',id,category_type_id,'.$data['category_type_id'],
        ];

        $rules['parent_id'] = ['nullable',new CategoryCanHaveChildrenRule($id,$data['category_type_id'])];

        $imageConfig = config('constant.image');
        $allowedExtensionsString = join(",",$imageConfig['allowed_extensions']);

        $rules['picture_object'] = [
            'nullable',
//            'image',
            'mimes:'.$allowedExtensionsString,
            'max:'.$imageConfig['max_size']
        ];

        return $rules;
    }
}

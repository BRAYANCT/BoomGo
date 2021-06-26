<?php

namespace App\Http\Requests\Admin;

use App\Rules\Category\CategoryCanRegisterToModelRule;
use App\Rules\NotSelectedRule;
use App\Rules\User\UserHasNoBusinessRule;
use Illuminate\Foundation\Http\FormRequest;

class BusinessFormAdminRequest extends FormRequest
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
        $accion = "";
        if(isset($data['_method'])){
            $accion =  $data['_method'];
        }

        //obtiene el id cuando está actualizando
        if($accion == "PUT"){
            $id = $this->route('business')->id;
        }

        $priceRangeId = $data['price_range_id'];

        $rules = array();

        if($accion != "PUT") {
            $rules['user_id'] = ['required', new NotSelectedRule, 'exists:users,id', new UserHasNoBusinessRule];
        }

        $rules['name'] = ['required','string','max:'.config('constant.attribute.name.max')];

        $rules['email'] = ['required','email','max:'.config('constant.attribute.email.max')];

        $rules['phone'] = ['required','numeric','digits_between:'.config('constant.attribute.phone.min').','.config('constant.attribute.phone.max')];

        $rules['whatsapp'] = ['nullable','regex:'.config('constant.attribute.cellphone.regex'),];


        $rules['category_id'] = [
            'required',
            new CategoryCanRegisterToModelRule(config('constant.categorytype.business_id')),
        ];

        $rules['price_range_id'] = ['nullable'];

        if($priceRangeId !== '0'){
            array_push($rules['price_range_id'],'exists:price_ranges,id');
        }

        $rules['description'] = ['nullable','string','max:'.config('constant.attribute.long_text.max')];

        $rules['catalog_link'] = ['nullable','url','max:'.config('constant.attribute.url.max')];

        $rules['provider_types_id'] = ['nullable','array'];

        $rules['provider_types_id.*'] = [
            'nullable','exists:provider_types,id'
        ];

        $rules['district_id'] = ['required',new NotSelectedRule,'exists:districts,id'];
        $rules['province_id'] = ['required',new NotSelectedRule,'exists:provinces,id'];
        $rules['department_id'] = ['required',new NotSelectedRule,'exists:departments,id'];

        $rules['address'] = ['nullable','string','max:'.config('constant.attribute.address.max')];
        $rules['latitude'] = ['nullable','numeric'];
        $rules['longitude'] = ['nullable','numeric'];

        $imageConfig = config('constant.image');
        $allowedExtensionsString = join(",",$imageConfig['allowed_extensions']);

        $rules['logo_object'] = [
            $accion == 'PUT' ? 'nullable' : 'required',
//            'image',
            'mimes:'.$allowedExtensionsString,
            'max:'.$imageConfig['max_size']
        ];

        $rules['image_gallery'] = [
            'nullable',
            'array'
        ];

        $rules['image_gallery.*'] = [
            'required',
//            'image',
            'mimes:'.$allowedExtensionsString,
            'max:'.$imageConfig['max_size']
        ];

        return $rules;
    }


    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'provider_types_id.*'=> 'El campo tiene un valor incorrecto.'
        ];
    }

}

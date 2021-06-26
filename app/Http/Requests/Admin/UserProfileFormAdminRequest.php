<?php

namespace App\Http\Requests\Admin;

use App\Rules\AlphaSpacesRule;
use App\Services\RoleServiceImpl;
use Illuminate\Foundation\Http\FormRequest;

class UserProfileFormAdminRequest extends FormRequest
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

        //obtiene el usuario autenticado
        $user =\Auth::user();
        $id = $user-> id;


        $rules = array();


        $rules['names'] = ['required',new AlphaSpacesRule,'max:'.config('constant.attribute.names.max')];
        $rules['surnames'] = ['required',new AlphaSpacesRule,'max:'.config('constant.attribute.surnames.max')];


        $rules['email'] = [
                            'required',
                            'email',
                            'unique:users,email,'.$id.',id',
                            'max:'.config('constant.attribute.email.max')
                        ];

        $rules['cambio_password'] = "required";

        if(filter_var($data['cambio_password'], FILTER_VALIDATE_BOOLEAN)){
            $rules['password'] = 'required|min:'.config('constant.attribute.password.min').'|max:'.config('constant.attribute.password.max').'|confirmed|regex:'.config('constant.attribute.password.regex');
        }

        $imageConfig = config('constant.image');

        $allowedExtensionsString = join(",",$imageConfig['allowed_extensions']);

        $rules['image'] = [
            'nullable',
//            'image',
            'mimes:'.$allowedExtensionsString,
            'max:'.$imageConfig['max_size']
        ];

        return $rules;
    }
}

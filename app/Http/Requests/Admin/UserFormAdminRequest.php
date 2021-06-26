<?php

namespace App\Http\Requests\Admin;

use App\Rules\AlphaSpacesRule;
use App\Services\RoleServiceImpl;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserFormAdminRequest extends FormRequest
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
        $action = "";
        if(isset($data['_method'])){
            $action =  $data['_method'];
        }

        //obtiene el id cuando está actualizando
        if($action == "PUT"){
            $id = $this->route('user')->id;
        }


        $rules = array();


        $rules['names'] = ['required',new AlphaSpacesRule,'max:'.config('constant.attribute.names.max')];
        $rules['surnames'] = ['required',new AlphaSpacesRule,'max:'.config('constant.attribute.surnames.max')];


        // actualizar
        // email:rfc,dns
        if($action == "PUT"){

            $rules['email'] = [
                                'required',
                                'email',
                                'unique:users,email,'.$id.',id',
                                'max:'.config('constant.attribute.email.max')
                            ];

        }else{
            $rules['email'] = ['required','email','unique:users,email,NULL,id','max:'.config('constant.attribute.email.max')];
        }

        $rules['role_id'] = ['required',
                                Rule::exists('roles','id')
                                    ->where(  function ($query) {
                                        $roleService = new RoleServiceImpl();
                                        $arrayIds = $roleService->findAllAllowedForAuthUser()
                                                                -> pluck('id');
                                        $query->whereIn('id', $arrayIds);
                                    })
                            ];

        if($action == "PUT"){
            $rules['user_state_id'] = ['required','exists:user_states,id'];
        }

        $rules['cambio_password'] = "required";

        if(filter_var($data['cambio_password'], FILTER_VALIDATE_BOOLEAN)){
            //cuando actualiza
            if($action == "PUT"){
                $rules['password'] = 'required|min:'.config('constant.attribute.password.min').'|max:'.config('constant.attribute.password.max').'|confirmed|regex:'.config('constant.attribute.password.regex');
            }else{
                $rules['password'] = 'required|min:'.config('constant.attribute.password.min').'|max:'.config('constant.attribute.password.max').'|regex:'.config('constant.attribute.password.regex');
            }

        }

        $imageConfig = config('constant.image');

        if($action == "PUT"){
            $allowedExtensionsString = join(",",$imageConfig['allowed_extensions']);

            $rules['image'] = [
                'nullable',
//                'image',
                'mimes:'.$allowedExtensionsString,
                'max:'.$imageConfig['max_size']
            ];
        }

        return $rules;
    }
}

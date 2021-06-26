<?php

namespace App\Http\Requests\Admin;

use App\Rules\Category\CategoryCanRegisterToModelRule;
use App\Rules\CustomBooleanRule;
use App\Rules\NotSelectedRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProductFormAdminRequest extends FormRequest
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

        $action = "";

        if(isset($data['_method'])){
            $action =  $data['_method'];
        }

        //obtiene el id cuando está actualizando
        if($action == "PUT"){
            $id = $this->route('product')->id;
        }

        $rules = array();

        $authUser = Auth::user();

        $isAdminBusiness = $data['is_admin_business'];

//        Log::debug("isAdminBusiness:".$isAdminBusiness);
//        Log::debug($data);

        $rules['is_admin_business'] = ['required',new CustomBooleanRule];

        if($authUser->canChooseBusiness() && !filter_var($isAdminBusiness, FILTER_VALIDATE_BOOLEAN)){
            $rules['business_id'] = ['required',new NotSelectedRule,'exists:businesses,id,deleted_at,NULL'];
        }

        $rules['name'] = ['required','string','max:'.config('constant.attribute.name.max')];

        $rules['categories_id'] = ['required','array'];

        $rules['categories_id.*'] = [
            'required',
            new CategoryCanRegisterToModelRule(config('constant.categorytype.product_id')),
        ];

        $rules['price'] = ['required','numeric','min:0'];

        $rules['short_description'] = ['required','string','max:500'];

        $rules['offer_date_range'] = ['required',new CustomBooleanRule];


        $offerDateRange = false;

        if(isset($data['offer_date_range'])){
            $offerDateRange = filter_var($data['offer_date_range'], FILTER_VALIDATE_BOOLEAN);
        }

        $rules['offer_price'] = [
            $offerDateRange ? 'required' : 'nullable',
            'numeric',
            'min:0',
            'lt:price'
        ];


        if($offerDateRange){
            $rules['offer_start_date'] = [
                $offerDateRange ? 'required' : 'nullable',
                'date_format:d/m/Y',
                'after_or_equal:today',
            ];

            $rules['offer_end_date'] = [
                $offerDateRange ? 'required' : 'nullable',
                'date_format:d/m/Y',
                'after_or_equal:offer_start_date',
            ];
        }


        $imageConfig = config('constant.image');
        $allowedExtensionsString = join(",",$imageConfig['allowed_extensions']);

        $rules['picture_object'] = [
            $action == 'PUT' ? 'nullable' : 'required',
//            'image',
            'mimes:'.$allowedExtensionsString,
            'max:'.$imageConfig['max_size']
        ];

        $rules['description'] = ['nullable','string','max:200000'];


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
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'categories_id.*' => 'categorías'
        ];
    }
}

<?php

namespace App\Http\Requests\Admin;

use App\Rules\CustomBooleanRule;
use App\Rules\NotSelectedRule;
use App\Rules\Shipping\ShippingableUniqueRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ShippingFormAdminRequest extends FormRequest
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
            $id = $this->route('shipping')->id;
        }

        $rules = array();

        $authUser = Auth::user();

        $isAdminBusiness = isset($data['is_admin_business']) ? $data['is_admin_business'] : false;
        $isAdminBusiness = filter_var($isAdminBusiness, FILTER_VALIDATE_BOOLEAN);

        $shippingType = isset($data['shipping_type']) ? $data['shipping_type'] : '';

        $businessId = isset($data['business_id']) ? $data['business_id'] : null;

        if($isAdminBusiness){
            $businessId = $authUser->business->id;
        }

        $rules['is_admin_business'] = ['required',new CustomBooleanRule];

        if($authUser->canChooseBusiness() && !$isAdminBusiness){
            $rules['business_id'] = ['required',new NotSelectedRule,'exists:businesses,id,deleted_at,NULL'];
        }

        $rules['shipping_type'] = ['required','in:department,province,district'];

        if(!empty($shippingType)){
            if($shippingType === "department"){
                $rules['department_id'] = ['required',new NotSelectedRule,'exists:departments,id',new ShippingableUniqueRule($id,$businessId,$shippingType)];
            }
            else if($shippingType === "province"){
                $rules['province_id'] = ['required',new NotSelectedRule,'exists:provinces,id',new ShippingableUniqueRule($id,$businessId,$shippingType)];
            }
            else if($shippingType === "district"){
                $rules['district_id'] = ['required',new NotSelectedRule,'exists:districts,id',new ShippingableUniqueRule($id,$businessId,$shippingType)];
            }
        }

        $rules['price'] = ['required','numeric','min:0'];


        return $rules;
    }
}

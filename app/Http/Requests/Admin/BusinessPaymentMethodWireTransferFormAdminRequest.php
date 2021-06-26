<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BusinessPaymentMethodWireTransferFormAdminRequest extends FormRequest
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
        return [
            'instructions' => ['required','string'],

            'name' => ['required','array'],

            'name.*' => ['required','string'],
            'account_number.*' => ['required','string'],
            'name_bank.*' => ['required','string'],
            'cci.*' => ['required','string'],
        ];
    }



    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Es necesario ingresar al menos 1 número de cuenta.',
            'name.array' => 'Es necesario ingresar al menos 1 número de cuenta.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name.*'=>'nombre de la cuenta',
            'account_number.*'=>'número de cuenta',
            'name_bank.*'=>'nombre del banco',
            'cci.*'=>'CCI',
        ];
    }
}

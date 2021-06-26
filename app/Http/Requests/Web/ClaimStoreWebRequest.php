<?php

namespace App\Http\Requests\Web;

use App\Rules\AlphaSpacesRule;
use App\Rules\NotSelectedRule;
use Illuminate\Foundation\Http\FormRequest;

class ClaimStoreWebRequest extends FormRequest
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

            'names' => ['required',new AlphaSpacesRule,'max:'.config('constant.attribute.names.max')],
            'surnames' => ['required',new AlphaSpacesRule,'max:'.config('constant.attribute.names.max')],
            'document_type_id' => ['required',new NotSelectedRule,'exists:document_types,id'],
            'identification_document' => ['required','string','max:'.config('constant.attribute.identification_document.max')],
            'phone' => ['nullable','min:'.config('constant.attribute.phone.min'),'max:'.config('constant.attribute.phone.max')],
            'email' => ['required','email','max:'.config('constant.attribute.email.max')],
            'district_id' => ['required',new NotSelectedRule,'exists:districts,id'],
            'province_id' => ['required',new NotSelectedRule,'exists:provinces,id'],
            'department_id' => ['required',new NotSelectedRule,'exists:departments,id'],
            'address' => ['required','string','max:'.config('constant.attribute.address.max')],

            'tutor_full_name' => ['nullable',new AlphaSpacesRule,'max:'.config('constant.attribute.full_name.max')],
            'tutor_email' => ['nullable','email','max:'.config('constant.attribute.email.max')],
            'tutor_document_type_id' => ['nullable',new NotSelectedRule,'exists:document_types,id'],
            'tutor_identification_document' => ['nullable','string','max:'.config('constant.attribute.identification_document.max')],

            'claim_type' => ['required','in:Reclamo,Queja'],
            'related_claim' => ['required','in:Producto,Servicio'],

            'detail_claims' => ['required','string'],
            'client_request' => ['required','string'],

            'agreed_to_be_owner' => ['required']
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
            'agreed_to_be_owner.required' => 'Es necesario aceptar la declaración jurada.'
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
            'identification_document'=> 'número Doc.',
            'phone' => 'Teléfono fijo/Celular',

            'tutor_full_name' => 'nombre completo del tutor',
            'tutor_email' => 'email del tutor',
            'tutor_document_type_id' => 'doc. identidad del tutor',
            'tutor_identification_document' => 'número de documento del tutor',


        ];
    }

}

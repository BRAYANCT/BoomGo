<?php

namespace App\Http\Requests\Web;

use App\Rules\AlphaSpacesRule;
use Illuminate\Foundation\Http\FormRequest;

class ContactStoreWebRequest extends FormRequest
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

            'phone' => ['required','min:'.config('constant.attribute.phone.min'),'max:'.config('constant.attribute.phone.max')],
            'email' => ['required','email','max:'.config('constant.attribute.email.max')],

            'company_name' => ['required','string','max:'.config('constant.attribute.company_name.max')],

        ];
    }
}

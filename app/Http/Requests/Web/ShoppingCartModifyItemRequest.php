<?php

namespace App\Http\Requests\Web;

use App\Rules\Product\AvailableToOrderRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ShoppingCartModifyItemRequest extends FormRequest
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
        $authUser = Auth::user();

        $rules = array();

        $rules['product_id'] = [
            'required',
            new AvailableToOrderRule,
        ];

        $rules['quantity'] = ['required','integer','min:1'];

        $rules['cookie_token'] = ['required','string'];

        return $rules;
    }
}

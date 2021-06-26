<?php

namespace App\Http\Requests\Web;

use App\Rules\AlphaSpacesRule;
use App\Rules\NotSelectedRule;
use App\Rules\PaymentMethod\BusinessHasPaymentMethodRule;
use App\Services\ShoppingCartServiceImpl;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderFormWebRequest extends FormRequest
{

    private $shoppingCartService;

    public function __construct()
    {
        $this-> shoppingCartService = new ShoppingCartServiceImpl();
    }

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
        $data = $this-> validationData();

        $business = $this->route('business');

//        Log::debug($data);
        $rules = array();


        $rules['names'] = ['required',new AlphaSpacesRule,'max:'.config('constant.attribute.names.max')];
        $rules['surnames'] = ['required',new AlphaSpacesRule,'max:'.config('constant.attribute.names.max')];


        $rules['district_id'] = ['required',new NotSelectedRule,'exists:districts,id'];
        $rules['province_id'] = ['required',new NotSelectedRule,'exists:provinces,id'];
        $rules['department_id'] = ['required',new NotSelectedRule,'exists:departments,id'];

        $rules['address'] = ['required','string','max:'.config('constant.attribute.address.max')];

        $rules['email'] = ['required','email'];

        // si no esta logueado verifica el email en la base de datos
        if(!Auth::check()){
            array_push($rules['email'],'unique:users,email,NULL,id');
        }


        $rules['phone'] = ['required','numeric','digits_between:'.config('constant.attribute.phone.min').','.config('constant.attribute.phone.max')];

        $rules['observation'] = ['nullable','string','max:10000'];

        $rules['payment_method_id'] = [
            'required',
            $business ? new BusinessHasPaymentMethodRule($business) : 'exists:payment_methods,id'
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
            'observation' => 'información adicional',
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
            'email.unique' => 'El email ya se encuentra registrado en la plataforma, inicie sesión para continuar.'
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {


        $shoppingCartCookie = \Cookie::get(config('constant.shoppingcart.name_cookie'));


        $validator->after(function ($validator)use($shoppingCartCookie) {

            $shoppingCart = $this->shoppingCartService->getShoppingCart($shoppingCartCookie);

//            $authUser = Auth::user();

            if($shoppingCart && count($shoppingCart->items) > 0 ){

//                foreach ($authUser-> shoppingCart-> items as $key => $element) {
//                    // si no existe el producto
//                    $result = ProductHelper::isAvailableToOrder($element-> product,$authUser);
//
//                    if(!$result){
//                        $validator->errors()->add('items.'.$key, "El producto {$element-> name} no se encuentra disponible.");
//                    }
//                }

            }else{
                $validator->errors()->add('shopping_cart', 'Su carrito de compras está vacio.');
            }

        });
    }

}

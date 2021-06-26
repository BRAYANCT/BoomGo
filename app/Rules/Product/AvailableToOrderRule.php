<?php

namespace App\Rules\Product;

use App\Product;
use Illuminate\Contracts\Validation\Rule;

class AvailableToOrderRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $product = Product::find($value);

        if($product){
            return $product->isAvailableToOrder();
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El producto no se encuentra disponible.';
    }
}

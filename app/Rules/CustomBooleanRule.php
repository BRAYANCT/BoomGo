<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CustomBooleanRule implements Rule
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
        return is_bool(filter_var($value,FILTER_VALIDATE_BOOLEAN));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El campo :attribute debe ser verdadero o falso.';
    }
}

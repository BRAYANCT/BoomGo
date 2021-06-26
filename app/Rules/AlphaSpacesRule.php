<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AlphaSpacesRule implements Rule
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
        // This will only accept alpha and spaces.
        // If you want to accept hyphens use: /^[\pL\s-]+$/u.
        $value = mb_strtolower($value);
        $value = preg_replace(array('/\á/','/\é/','/\í/','/\ó/','/\ú/','/\ñ/'),array('a','e','i','o','u','n'), $value);

        return preg_match('/^[\pL\s]+$/u', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        // return 'El campo :attribute solo puede contener letras y espacio.';
        return trans('validation.alpha_spaces');
    }
}

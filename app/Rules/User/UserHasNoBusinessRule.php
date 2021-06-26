<?php

namespace App\Rules\User;

use App\User;
use Illuminate\Contracts\Validation\Rule;

class UserHasNoBusinessRule implements Rule
{

    private $message = 'El usuario ya tiene un negocio asignado.';

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
     * Verifica si el usuario tiene un negocio registrado.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $userId)
    {
        $user = User::find($userId);

        if($user){
            return !$user->business;
        }else{
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}

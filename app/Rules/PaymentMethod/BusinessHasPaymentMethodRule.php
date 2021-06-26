<?php

namespace App\Rules\PaymentMethod;

use App\Business;
use App\Services\PaymentMethodServiceImpl;
use Illuminate\Contracts\Validation\Rule;

class BusinessHasPaymentMethodRule implements Rule
{
    private $paymentMethodService;
    private $business;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Business $business)
    {
        $this->paymentMethodService = new PaymentMethodServiceImpl();
        $this->business = $business;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $paymentMethodId)
    {
        $paymentMethods = $this->paymentMethodService->findAllByBusiness($this->business);

        if(count($paymentMethods) > 0){
            return count($paymentMethods->where('id',$paymentMethodId)) > 0;
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
        return 'El método de pago es inválido.';
    }
}

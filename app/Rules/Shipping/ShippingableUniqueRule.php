<?php

namespace App\Rules\Shipping;

use App\Department;
use App\District;
use App\Province;
use App\Shipping;
use Illuminate\Contracts\Validation\Rule;
use phpDocumentor\Reflection\Types\Integer;

class ShippingableUniqueRule implements Rule
{
    private $id;
    private $shippingType;
    private $businessId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id="",$businessId ,$shippingType)
    {
        $this->id = $id;
        $this->shippingType = $shippingType;
        $this->businessId = $businessId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $shippingableId
     * @return bool
     */
    public function passes($attribute, $shippingableId)
    {

        $shipping = Shipping::where('shippingable_id',$shippingableId)
            ->where('shippingable_type',$this->getShippingableType())
            ->where('business_id',$this->businessId)
            ->where('id','!=',$this->id)
            ->first();

        return $shipping ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if($this->shippingType === "department"){
            return 'Ya existe un envío para registrado para el departamento.';
        }
        else if($this->shippingType === "province"){
            return 'Ya existe un envío para registrado para la provincia.';
        }
        else if($this->shippingType === "district"){
            return 'Ya existe un envío para registrado para el distrito.';
        }

        return 'El campo :attribute ya se encuentra registrado en el sistema.';
    }

    /**
     * Obtiene el valor del shippinable_type.
     *
     * @return string
     */
    public function getShippingableType()
    {
        if($this->shippingType === "department"){
            return Department::class;
        }
        else if($this->shippingType === "province"){
            return Province::class;
        }
        else if($this->shippingType === "district"){
            return District::class;
        }
        return "";
    }
}

<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessPaymentMethodAdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this-> id,
            'payment_method_id' => $this->payment_method_id,
            'business_id' => $this->business_id,
            'access_token' => $this-> access_token,
            'public_key'=> $this-> public_key,
            'client_id'=> $this-> client_id,
            'refresh_token'=> $this-> refresh_token,
            'date_expire_token'=> $this-> date_expire_token,

            'description'=> $this-> description,
            'instructions'=> $this-> instructions,

            'account_numbers'=> new AccountNumberAdminResource($this->whenLoaded('accountNumbers'))
        ];
    }
}

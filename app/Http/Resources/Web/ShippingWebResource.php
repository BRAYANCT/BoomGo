<?php

namespace App\Http\Resources\Web;

use App\Http\Resources\Admin\ShippingableAdminResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ShippingWebResource extends JsonResource
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
            'business_id' => $this->business_id,
            'shippingable_id' => $this->shippingable_id,
            'shippingable_type' => $this->shippingable_type,
            'price' => $this->price,
            'shipping_type_name' => $this->shipping_type_name,
            'shipping_type' => $this->shipping_type,
        ];
    }
}

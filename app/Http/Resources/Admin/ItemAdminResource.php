<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemAdminResource extends JsonResource
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
            'itemable_id' => $this->itemable_id,
            'itemable_type' => $this->itemable_type,
            'product_id' => $this-> product_id,
            'name' => $this-> name,
            'price' => $this-> price,
            'quantity' => $this-> quantity,
            'subtotal' => $this-> subtotal,

            'final_price' => $this-> final_price,
            'offer_price' => $this-> offer_price,
            'offer_active' => $this-> offer_active,

            'product'=> new ProductAdminResource($this->whenLoaded('product')),
        ];
    }
}

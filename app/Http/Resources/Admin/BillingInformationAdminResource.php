<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BillingInformationAdminResource extends JsonResource
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
            'district_id'=> $this->district_id,
            'names' => $this->names,
            'surnames' => $this->surnames,
            'email' => $this->email,
            'phone' => $this-> phone,
            'address'=> $this-> address,

            'district'=> new DistrictAdminResource($this->whenLoaded('district')),
//            'order_group'=> new OrderGroupAdminResource($this->whenLoaded('priceRange')),

        ];
    }
}

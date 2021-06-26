<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderAdminResource extends JsonResource
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
            'code' => $this-> code,
            'shipping_price' => $this-> shipping_price,
            'created_at' => $this-> created_at,
            'display_created_at' => $this-> display_created_at,
            'display_date_created_at' => $this-> display_date_created_at,
            'display_hour_created_at' => $this-> display_hour_created_at,

            $this->mergeWhen($this->relationLoaded('items'), [
                'sub_total' => $this-> sub_total,
                'total' => $this-> total,
                'total_quantity' => $this-> total_quantity,
            ]),

            'order_state'=> new OrderStateAdminResource($this->whenLoaded('orderState')),
            'items'=> ItemAdminResource::collection($this->whenLoaded('items')),
        ];
    }
}

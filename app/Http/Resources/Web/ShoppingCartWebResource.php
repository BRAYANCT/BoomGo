<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class ShoppingCartWebResource extends JsonResource
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
            'user_id' => $this-> user_id,
            'cookie_token' => $this->cookie_token,
            'display_date_created_at' => $this-> display_date_created_at,
            'display_created_at' => $this-> display_created_at,

            $this->mergeWhen($this->relationLoaded('items'), [
                'total' => $this-> total,
                'total_quantity' => $this-> total_quantity,
            ]),

            'items' => ItemWebResource::collection($this->whenLoaded('items')),
        ];
    }
}

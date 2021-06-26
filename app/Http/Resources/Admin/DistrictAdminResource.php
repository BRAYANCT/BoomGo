<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class DistrictAdminResource extends JsonResource
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
            'name' => $this->name,
            'province_id' => $this->province_id,

            'province'=> new ProvinceAdminResource($this->whenLoaded('province')),
        ];
    }
}

<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class ProvinceWebResource extends JsonResource
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
            'department_id' => $this->department_id,

            $this->mergeWhen($this->relationLoaded('businesses'), [
                'total_businesses' => $this-> businesses->count(),
            ]),

        ];
    }
}

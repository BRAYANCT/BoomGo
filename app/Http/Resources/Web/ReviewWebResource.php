<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewWebResource extends JsonResource
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
            'user_id' => $this->user_id,
            'model_id' => $this->model_id,
            'model_type' => $this-> model_type,
            'score'=> $this-> score,
            'commentary'=> $this-> commentary,

            'display_date_created_at' => $this->display_date_created_at,
            'display_created_at' => $this->display_created_at,

            'reviewable' => new BusinessWebResource($this->whenLoaded('reviewable')),
            'user'=> new UserWebResource($this->whenLoaded('user'))
        ];
    }
}

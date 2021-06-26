<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryAdminResource extends JsonResource
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
            'category_type_id' => $this->category_type_id,
            'parent_id' => $this->parent_id,
            'name' => $this-> name,
            'slug' => $this-> slug,
            'level' => $this-> level,
            'url_page' => $this-> url_page,

            'parent'=> new CategoryAdminResource($this->whenLoaded('parent')),
            'childs'=> CategoryAdminResource::collection($this->whenLoaded('childs')),
        ];
    }
}

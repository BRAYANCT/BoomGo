<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryWebResource extends JsonResource
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

            'picture_url_thumbnail' => $this-> getUrlThumbnail('picture',true,true),
            'picture_url_medium' => $this-> getUrlImageMedium('picture',true,true),
            'picture_url_large' => $this-> getUrlImageLarge('picture',true,true),
            'picture_url' => $this-> getUrlImage('picture',true),

            'default_picture_url' => $this-> default_picture_url,

            'parent'=> new CategoryWebResource($this->whenLoaded('parent')),
            'childs'=> CategoryWebResource::collection($this->whenLoaded('childs')),

            $this->mergeWhen($this->relationLoaded('businesses'), [
                'total_businesses' => $this-> total_businesses,
            ]),

        ];
    }
}

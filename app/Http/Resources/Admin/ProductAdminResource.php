<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductAdminResource extends JsonResource
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
            'business_id' => $this-> business_id,
            'name' => $this-> name,
            'slug'=>$this-> slug,
            'short_description' => $this->short_description,
            'description'=> $this->description,
            'price'=> $this->price,
            'offer_price'=> $this->offer_price,
            'offer_start_date'=> $this->offer_start_date,
            'offer_end_date'=> $this->offer_end_date,
            'offer_date_range'=> $this->offer_date_range,
            'picture'=> $this->picture,
            'active'=> $this->active,

            'picture_url_thumbnail' => $this-> getUrlThumbnail('picture',true,true),
            'picture_url_medium' => $this-> getUrlImageMedium('picture',true,true),
            'picture_url_large' => $this-> getUrlImageLarge('picture',true,true),
            'picture_url' => $this-> getUrlImage('picture',true),
            'url_page'=> $this->url_page,
            'display_offer_start_date'=> $this->display_offer_start_date,
            'display_offer_end_date'=> $this->display_offer_end_date,

            'categories'=> CategoryAdminResource::collection($this->whenLoaded('categories')),
            'images'=> ImageAdminResource::collection($this->whenLoaded('images')),
        ];
    }
}

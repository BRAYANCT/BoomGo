<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessAdminResource extends JsonResource
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
            'user_id'=> $this->user_id,
            'category_id' => $this->category_id,
            'price_range_id' => $this->price_range_id,
            'district_id' => $this->district_id,
            'name' => $this-> name,
            'email'=> $this-> email,
            'phone'=> $this-> phone,
            'whatsapp'=> $this-> whatsapp,
            'slug' => $this-> slug,
            'logo' => $this-> logo,
            'address' => $this-> address,
            'latitude' => $this-> latitude,
            'longitude' => $this-> longitude,
            'description' => $this-> description,

            'logo_url_thumbnail' => $this-> getUrlThumbnail('logo',true,true),
            'logo_url_medium' => $this-> getUrlImageMedium('logo',true,true),
            'logo_url_large' => $this-> getUrlImageLarge('logo',true,true),
            'logo_url' => $this-> getUrlImage('logo',true),

            'url_page' => $this-> url_page,

            'reviews'=> ReviewAdminResource::collection($this->whenLoaded('reviews')),

            $this->mergeWhen($this->relationLoaded('reviews'), [
                'score_average' => $this-> score_average,
                'total_reviews' => $this-> total_reviews,
            ]),

            'user'=> new UserAdminResource($this->whenLoaded('user')),
            'price_range'=> new PriceRangeAdminResource($this->whenLoaded('priceRange')),
            'category'=> new CategoryAdminResource($this->whenLoaded('category')),
            'provider_types'=> ProviderTypeAdminResource::collection($this->whenLoaded('providerTypes')),
            'images'=> ImageAdminResource::collection($this->whenLoaded('images')),

            'district'=> new DistrictAdminResource($this->whenLoaded('district')),

        ];
    }
}

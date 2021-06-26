<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class UserWebResource extends JsonResource
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
            'names' => $this-> names,
            'surnames' => $this-> surnames,
            'created_at' => $this-> created_at,
            'first_name' => $this-> first_name,
            'first_surname' => $this-> first_surname,
            'full_name' => $this-> full_name,
            'display_name' => $this-> display_name,
            'display_created_at' => $this-> display_created_at,

            'profile_picture_url_thumbnail' => $this-> getUrlThumbnail('profile_picture',true,true),
            'profile_picture_url_medium' => $this-> getUrlImageMedium('profile_picture',true,true),
            'profile_picture_url_large' => $this-> getUrlImageLarge('profile_picture',true,true),
            'profile_picture_url' => $this-> getUrlImage('profile_picture',true),

            'profile_picture_default_url'=> $this->profile_picture_default_url,

        ];
    }
}

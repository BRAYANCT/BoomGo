<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageAdminResource extends JsonResource
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
            'name' => $this-> name,
            'picture_url_thumbnail' => $this-> getUrlThumbnail('name',true,true),
            'picture_url_medium' => $this-> getUrlImageMedium('name',true,true),
            'picture_url_large' => $this-> getUrlImageLarge('name',true,true),
            'picture_url' => $this-> getUrlImage('name',true),
            'display_date_created_at'=>$this-> display_date_created_at,
            'display_created_at'=>$this-> display_created_at,
        ];
    }
}
